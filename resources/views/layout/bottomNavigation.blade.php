<div class="appBottomMenu">
        <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="/jahit/pesan" class="item {{ request()->is('vote/create') ? 'active' : '' }}">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="shirt-outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/jahit/addbukti" class="item {{ request()->is('sispilu/voters/add') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Add Bukti</strong>
            </div>
        </a>
    </div>
