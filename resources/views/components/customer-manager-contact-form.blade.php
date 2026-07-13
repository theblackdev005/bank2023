{{-- MODAL BOX --}}
<div class="modal fade text-left" id="my-modalBox__manager_contact_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title pm-0" id="myModalLabel">{{ translate(550) }}</h5>
                <i class="fa fa-close" data-dismiss="modal"></i>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ routeWithLocale('guest.contact') }}" method="post">
                    @csrf

                    @livewire('advanced-contact-form', [
                        'accountCustomer' => customer(),
                    ])
                </form>
            </div>
            
        </div>
    </div>
</div>
{{-- MODAL BOX --}}