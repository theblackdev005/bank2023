<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            @foreach (rib_keys() as $key => $label)
                @if ( !empty($rib->$key) )
                    <td class="bg-white">
                        <small>{{ translate($label) }}</small><br>
                        <span class="badge badge-secondary">
                            {{ $rib->$key }}
                        </span>
                        <span class="material-symbols-outlined base copy cursor-pointer" data-copy="{{ $rib->$key }}">content_copy</span>
                    </td>
                @endif
            @endforeach
        </tr>
    </table>
</div>