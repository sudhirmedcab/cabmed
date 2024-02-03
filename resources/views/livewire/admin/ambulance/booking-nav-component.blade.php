<div class="card text-center mt-2 mb-2">
    <div class="custom__driver__filter card-header">
        <ul class="nav nav-tabs custom__nav__tab  card-header-tabs d-flex justify-content-around overflow-auto flex-nowrap">
            <li class="nav-item">
                <a class="nav-link fs-1" href="#">Dashboard</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link fs-1 " href="/driver" wire:navigate>All</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link">Generate</a>
            </li>
            <li class="nav-item ">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('division')">
                    Scheduled
                </a>
            </li>
            <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('district')">
                    Auto Search
                </a>
            </li>
            <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('walletBalance')">
                    Emergency
                </a>
            </li>
            <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 " wire:click="filterCondition('Active')">
                    Air Ambulance
                </a>
            </li>
        </ul>
    </div>
</div>