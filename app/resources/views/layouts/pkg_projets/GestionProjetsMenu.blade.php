<li class="nav-item has-treeview">
    <a class="nav-link {{ Request::is('projets*') ? 'active' : '' }}">
        <i class="fas fa-folder"></i>
        <p>
            Gestion de projets 
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('projets.index') }}" class="nav-link {{ Request::is('projets*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Projets</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('taches.index') }}" class="nav-link {{ Request::is('projets/taches*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Tâches</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('taches.gantt') }}" class="nav-link {{ Request::is('projets/taches/diagramme-de-gantt*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>Diagramme de Gantt</p>
            </a>
        </li>
    </ul>
</li>
