<tr>
    <td class="col-lg-2 text-center">

        @if ( $customer->isPending() )
            <button type="button" disabled class="btn-xs btn btn-success font-weight-bold">Modifier</button>
        @else
            <a href="{{ routeWithLocale('admin.edit_customer', $customer->username) }}" class="btn-xs btn btn-success font-weight-bold">Modifier</a>
        @endif
        
    </td>
    <td class="col-lg-1 text-center">
        <x-customer-avatar size="60" src="{{ asset_avatar($customer->image) }}" />
    </td>
    <td title="Inscrit le : {{ dateFormat($customer->created_at) }}" class="col-lg-6">
        <div class="row">
            <div class="col-lg-6">
                <span class="d-block">{{ $customer->fullname() }}</span>
                <span class="d-block">
                    <strong class="badge font-weight-bold text-white badge-info cursor-pointer">
                        <span>{{ setCurrency($customer->currency, $customer->balance) }}</span>
                        
                        @if ( !$customer->isPending() )
                            <span class="fa fa-edit font-weight-bold text-warning" data-toggle="modal" data-target="#my-balanceBox__{{ $customer->username }}"></span>
                        @endif
                    </strong>
                    <!-- MODAL -->
                    <div class="modal fade text-left" id="my-balanceBox__{{ $customer->username }}" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- Modal Header --}}
                                <div class="modal-header text-center">
                                    <h3 class="modal-title pm-0" id="myModalLabel">{{ $customer->fullname() }}</h3>
                                </div>
                                {{-- Modal Header --}}
                                
                                {{-- Modal Body --}}
                                <div class="modal-body px-4 pt-2 pb-1">
                                    <form action="{{ routeWithLocale('admin.customer_balance.post', $customer->username) }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label class="form-label required-field">{{ translate(616) }} ( en <span class="badge badge-info">{{ $customer->currency->name }}</span> )</label>
                                            <input type="text" name="balance" value="{{ $customer->balance }}" autocapitalize="none" autocomplete="nope" autocorrect="off" class="form-control" required>
                                            <input type="hidden" name="customer_id" value="{{ $customer->id }}" class="form-control d-none" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success font-weight-bold m-0"><i class="fa fa-check-circle mr-1"></i> Maj</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- Modal Body --}}

                                {{-- Modal Footer --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-xs font-weight-bold" data-dismiss="modal">Annuler</button>
                                </div>
                                {{-- Modal Footer --}}
                            </div>
                        </div>
                    </div>
                    <!-- MODAL -->
                </span>
                <span class="d-block">

                    @if ( $customer->isBanned() && ($type === 'banned') )
                        <strong class="badge bg-dark">
                            <span class="fa fa-ban text-danger"></span>
                            <span class="text-white text-uppercase">Banni</span>
                        </strong>
                    @elseif ( $customer->isPending() && ($type === 'pending') )
                        <strong class="badge bg-dark">
                            <span class="fa fa-close text-light"></span>
                            <span class="text-light text-uppercase">En attente</span>
                        </strong>
                    @else
                        <strong class="badge bg-dark">
                            <span class="fa fa-check-circle text-success"></span>
                            <span class="text-white text-uppercase">Actif</span>
                        </strong>
                    @endif

                </span>
            </div>
            <div class="col-lg-6">
                <span class="d-block">
                    <span class="d-block">{{ $customer->city }}</span>
                    <span class="d-block font-weight-bold">{{ $customer->country->name }}</span>
                </span>
            </div>
        </div>
    </td>
    <td class="col-lg-1">

        @if ( $customer->isBanned() || $customer->isPending() )
            <button type="button" disabled class="btn-xs btn btn-primary font-weight-bold">
                <span class="badge bg-white text-dark">{{ $customer->transactions()->count() }}</span>
                <span>Transaction</span>
            </button>
        @else
            <a href="{{ routeWithLocale('admin.transactions', $customer->username) }}" class="btn-xs btn btn-primary font-weight-bold">
                <span class="badge bg-white text-dark">{{ $customer->transactions()->count() }}</span>
                <span>Transaction</span>
            </a>
        @endif
        
    </td>
    <td class="col-lg-2 text-center">

        @if ( $customer->isBanned() || $customer->isPending() )
            <button type="button" disabled class="btn-xs btn btn-warning font-weight-bold">
                <span class="badge bg-white text-dark">{{ $customer->transferts()->count() }}</span>
                <span>Transfert</span>
            </button>
        @else
            <a href="{{ routeWithLocale('admin.transferts', $customer->username) }}" class="btn-xs btn btn-warning font-weight-bold">
                <span class="badge bg-white text-dark">{{ $customer->transferts()->count() }}</span>
                <span>Transfert</span>
            </a>
        @endif
        
    </td>
    
    <td class="col-lg-1">

        @if ( $customer->isBanned() && ($type === 'banned') )
            <a href="{{ routeWithLocale('admin.customer_lock', $customer->username) }}" class="btn-xs btn font-weight-bold btn-success confirm-action" data-message="Êtes-vous certains de vouloir débloquer ce client ?">Débloq.</a>
        @elseif ( $customer->isPending() && ($type === 'pending') )
        <form action="{{ routeWithLocale('admin.customer_verification.post', $customer->username) }}" method="POST" class="confirm-action" data-message="Êtes-vous certain de vouloir valider le compte de ce client ?">
                @csrf
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-xs font-weight-bold m-0"><i class="fa fa-check-circle mr-1"></i> Valider</button>
                </div>
            </form>
        @else
            <a href="{{ routeWithLocale('admin.customer_lock', $customer->username) }}" class="btn-xs btn font-weight-bold btn-danger" data-message="Êtes-vous certains de vouloir bloquer ce client ?">Bloquer</a>
        @endif

    </td>
</tr>