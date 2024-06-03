@if ($taches->isEmpty())
    <div class="alert alert-warning m-3">
        <strong>{{ __('app.Aucune') }} {{ __('pkg_projets/taches/task.singular') }} {{ __('app.disponible') }}</strong>
    </div>
@else
    <div class="mermaid">
        gantt
        dateFormat YYYY-MM-DD
        title {{ $taches->first()->Projet->nom }}

        @foreach ($taches->groupBy('Projet.nom') as $projetNom => $tachesParProjet)
            section {{ $projetNom }}
            @foreach ($tachesParProjet as $tache)
                {{ $tache->nom }} : {{ $tache->StatutTache->nom }}, {{ $tache->dateDebut }}, {{ $tache->dateEchéance }}
            @endforeach
        @endforeach
    </div>
@endif
