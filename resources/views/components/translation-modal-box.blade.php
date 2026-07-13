<div id="language-box-modal" class="modal fade bg-theme bd-example-modal-lg" style="opacity: 0.96 !important;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 bg-transparent">
        
        <div class="modal-header border-0">
            <h4 class="modal-title font-weight-bold text-white" id="exampleModalLongTitle">{{ translate(32) }}</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 px-0">
                        <div class="styl-card p-4 bg-white" style="opacity: 1 !important;" id="i18n__modal">
                            <div>
                                @foreach ( \App\Models\Language::active() as $language)
                                    <a href="{{ routeSetLocale($language->iso) }}" class="i18n__link text-dark {{ (app()->getLocale() == $language->iso) ? 'active' : '' }} notranslate">
                                        <img src="{{ asset_img('flags/' . $language->iso . '.svg') }}" alt="">
                                        <span class="label">{{ ucfirst($language->name) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>
</div>