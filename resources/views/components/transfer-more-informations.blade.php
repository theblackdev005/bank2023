<div class="card">
    <div class="card-body">

        @if ($fee)
            <h4 class="card-title m-0 mb-3">{{ ucfirst($fee->name) }}</h4>
            <p class="card-text">{{ ucfirst($fee->instructions) }}</p>
        @else
            <h4 class="card-title m-0 mb-3">{{ translate(351) }}</h4>
            <p class="card-text">{{ translate(849) }}</p>
        @endif
        
        <div class="mt-3">
            <a href="javascript:;" data-toggle="modal" data-target="#my-modalBox__manager_contact_form" class="btn btn-dark mt-2 radius-25px">
                <i class="fa fa-envelope"></i>
                <span>{{ translate(550) }}</span>
            </a>
        </div>
    </div>
</div>