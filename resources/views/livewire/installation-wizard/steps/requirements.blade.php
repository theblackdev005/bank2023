<div wire:init="init">
    <table class="table table-sm table-bordered text-left">
        <tbody>
            @foreach ($requirements as $label => $requirement)
                <tr>
                    <td class="px-3 text-muted">{{ $label }}</td>
                    <td @class([
                            'text-center',
                            'px-3',
                            'bg-light',
                        ])>
                        <span class="text-muted">{{ $requirement['value'] }}</span>
                        <span @class([
                            'fa fa-check-circle',
                            'text-danger' => !$requirement['compatibility'],
                            'text-success' => $requirement['compatibility'],
                        ])></span>
                    </td>
                    <td class="text-center">
                        <button @disabled(!$requirement['need_action']) type="button" wire:click="set_requirement('{{ $label }}')" class="btn btn-sm btn-success">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>