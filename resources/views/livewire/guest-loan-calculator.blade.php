<div>
    <div>
        <x-form-input
            type="number" 
            name="montant_du_pret" 
            wiremodel="montant_du_pret" 
            label="{{ translate(353) }}"/>

        <x-form-select 
            name="monnaie_locale" 
            wiremodel="monnaie_locale" 
            :options=$currencies 
            selectLabel="{{ translate(594) }}" 
            optionLabelKey="name" 
            callback="currency_view_map" 
            optionValueKey="id" />

        <x-form-input
            type="number" 
            name="duree_du_pret" 
            wiremodel="duree_du_pret" 
            label="{{ translate(354) }}"/>
    </div>
    <div class="pt-3">
        <hr>
        <table class="table table-sm">
            <tr>
                <td class="border-0 col-6">{{ translate(353) }}</td>
                <td class="border-0 col-6 text-right font-weight-bold">
                    <span class="d-block py-2 bg-light border text-dark badge text-right">{{ setCurrency($currency, $montant_du_pret) }}</span>
                </td>
            </tr>
            <tr>
                <td class="border-0 col-6">{{ translate(341) }}</td>
                <td class="border-0 col-6 text-right font-weight-bold">
                    <span class="d-block py-2 bg-light border text-dark badge text-right">{{ $duree_du_pret }} {{ translate(344) }}</span>
                </td>
            </tr>
            <tr>
                <td class="border-0 col-6">{{ translate(342) }}</td>
                <td class="border-0 col-6 text-right font-weight-bold">
                    <span class="d-block py-2 bg-light border text-dark badge text-right">{{ TEAG }}%</span>
                </td>
            </tr>
            <tr>
                <td class="border-0 col-6">{{ translate(343) }}</td>
                <td class="border-0 col-6 text-right font-weight-bold">
                    <span class="d-block py-2 bg-light border text-dark badge text-right">{{ setCurrency($currency, $mensualite) }}</span>
                </td>
            </tr>
        </table>
    </div>
</div>