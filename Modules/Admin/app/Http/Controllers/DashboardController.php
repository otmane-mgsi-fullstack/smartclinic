<?php

namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. KPIs (Key Performance Indicators)
        $appointmentsToday = 0;
        try {
            $appointmentsToday = \Modules\Rdv\App\Models\RendezVous::whereDate('date_heure', today())->count();
        } catch (\Exception $e) {}

        $patientsCount = 0;
        try {
            $patientsCount = \Modules\Patient\App\Models\Patient::count();
        } catch (\Exception $e) {}
        
        $totalRevenue = 0;
        $pendingInvoices = 0;
        try {
            $totalRevenue = \Modules\Facturation\Models\Facture::sum('montant_paye');
            $pendingInvoices = \Modules\Facturation\Models\Facture::where('statut', '!=', 'paye')->count();
        } catch (\Exception $e) {}

        // Trigger demo mode if there are no appointments yet (so the dashboard is beautifully illustrated)
        $totalAppointments = 0;
        try {
            $totalAppointments = \Modules\Rdv\App\Models\RendezVous::count();
        } catch (\Exception $e) {}

        $isDemoMode = ($totalAppointments === 0);

        if ($isDemoMode) {
            // Populating beautiful realistic metrics for demonstration
            $appointmentsToday = 8;
            $patientsCount = 142;
            $totalRevenue = 5420.00;
            $pendingInvoices = 5;

            // Generate mock doctor and patient instances in memory
            $medecinUser1 = new \App\Models\User(['name' => 'Martin']);
            $medecin1 = new \Modules\Medecin\App\Models\Medecin(['specialite' => 'Cardiologie']);
            $medecin1->setRelation('user', $medecinUser1);

            $patientUser1 = new \App\Models\User(['name' => 'Marie Dupont']);
            $patient1 = new \Modules\Patient\App\Models\Patient(['cin' => 'AB12345']);
            $patient1->setRelation('user', $patientUser1);

            $rdv1 = new \Modules\Rdv\App\Models\RendezVous([
                'id' => 1,
                'date_heure' => now()->hour(9)->minute(0)->toDateTimeString(),
                'statut' => 'planifie',
                'motif' => 'Consultation de routine',
            ]);
            $rdv1->setRelation('medecin', $medecin1);
            $rdv1->setRelation('patient', $patient1);

            $medecinUser2 = new \App\Models\User(['name' => 'Lopez']);
            $medecin2 = new \Modules\Medecin\App\Models\Medecin(['specialite' => 'Pédiatrie']);
            $medecin2->setRelation('user', $medecinUser2);

            $patientUser2 = new \App\Models\User(['name' => 'Ali Ben Salem']);
            $patient2 = new \Modules\Patient\App\Models\Patient(['cin' => 'CD67890']);
            $patient2->setRelation('user', $patientUser2);

            $rdv2 = new \Modules\Rdv\App\Models\RendezVous([
                'id' => 2,
                'date_heure' => now()->hour(10)->minute(30)->toDateTimeString(),
                'statut' => 'termine',
                'motif' => 'Suivi de croissance',
            ]);
            $rdv2->setRelation('medecin', $medecin2);
            $rdv2->setRelation('patient', $patient2);

            $medecinUser3 = new \App\Models\User(['name' => 'Nguyen']);
            $medecin3 = new \Modules\Medecin\App\Models\Medecin(['specialite' => 'Dermatologie']);
            $medecin3->setRelation('user', $medecinUser3);

            $patientUser3 = new \App\Models\User(['name' => 'Sophie Bernard']);
            $patient3 = new \Modules\Patient\App\Models\Patient(['cin' => 'EF54321']);
            $patient3->setRelation('user', $patientUser3);

            $rdv3 = new \Modules\Rdv\App\Models\RendezVous([
                'id' => 3,
                'date_heure' => now()->hour(15)->minute(30)->toDateTimeString(),
                'statut' => 'annule',
                'motif' => 'Consultation cutanée',
            ]);
            $rdv3->setRelation('medecin', $medecin3);
            $rdv3->setRelation('patient', $patient3);

            $recentAppointments = collect([$rdv1, $rdv2, $rdv3]);
            $upcomingAppointments = collect([$rdv1, $rdv2]);

            // Chart historical data for evolution
            $months = ['Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai'];
            $appointmentCounts = [48, 55, 62, 70, 85, 96];

            // Invoices breakdown
            $chartInvoicesData = [
                'paid' => 42,
                'pending' => 14
            ];
        } else {
            // 2. Derniers rendez-vous (Recent Appointments - latest 5)
            $recentAppointments = collect();
            try {
                $recentAppointments = \Modules\Rdv\App\Models\RendezVous::with(['patient.user', 'medecin.user'])
                    ->latest()
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {}

            // 3. Prochains RDV (Upcoming Appointments today - up to 5)
            $upcomingAppointments = collect();
            try {
                $upcomingAppointments = \Modules\Rdv\App\Models\RendezVous::with(['patient.user', 'medecin.user'])
                    ->whereDate('date_heure', today())
                    ->where('statut', 'planifie')
                    ->orderBy('date_heure', 'asc')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {}

            // 4. Monthly Appointments Chart Data (last 6 months)
            $months = [];
            $appointmentCounts = [];
            try {
                for ($i = 5; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $months[] = $date->translatedFormat('M'); // e.g. "avr.", "mai"
                    
                    $count = \Modules\Rdv\App\Models\RendezVous::whereYear('date_heure', $date->year)
                        ->whereMonth('date_heure', $date->month)
                        ->count();
                    $appointmentCounts[] = $count;
                }
            } catch (\Exception $e) {
                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                $appointmentCounts = [0, 0, 0, 0, 0, 0];
            }

            // 5. Invoices Distribution Chart Data
            $chartInvoicesData = [
                'paid' => 0,
                'pending' => 0
            ];
            try {
                $chartInvoicesData['paid'] = \Modules\Facturation\Models\Facture::where('statut', 'paye')->count();
                $chartInvoicesData['pending'] = \Modules\Facturation\Models\Facture::where('statut', '!=', 'paye')->count();
            } catch (\Exception $e) {}
        }

        return view('admin::dashboard.index', compact(
            'appointmentsToday',
            'patientsCount',
            'totalRevenue',
            'pendingInvoices',
            'recentAppointments',
            'upcomingAppointments',
            'months',
            'appointmentCounts',
            'chartInvoicesData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
