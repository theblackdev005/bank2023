@extends('layouts.customer')

@section('style')
	<style>
		.transfer-form {
			margin-top: 0 !important;
			padding: 1.5rem !important;
			border-radius: 4px;
			background: #f6f7f8 !important;
		}
		.transfer-section {
			margin-bottom: 1.5rem;
			padding: 1.75rem;
			border: 1px solid #e1e5e9;
			border-radius: 4px;
			background: #fff;
		}
		.transfer-section-title {
			margin: 0 0 1.5rem;
			padding-bottom: 1rem;
			border-bottom: 1px solid #e7eaed;
			color: #2d3339 !important;
			font-size: 1.1rem;
			font-weight: 600;
		}
		.transfer-form .form-group {
			margin-bottom: 1.35rem;
		}
		.transfer-form .form-group > label:not(.transfert_to__label) {
			margin-bottom: .55rem;
			font-weight: 600;
		}
		.transfer-form .form-control {
			min-height: 50px;
		}
		.transfer-methods {
			margin-bottom: .5rem;
		}
		.transfer-method {
			margin-bottom: .75rem;
		}
		.transfer-method .transfert_to__label {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 52px;
			margin-bottom: 0;
			border-radius: 4px;
		}
		.bank-recipient-box {
			max-width: none;
			margin-bottom: 0 !important;
		}
		.recipient-mode {
			display: flex;
			gap: .75rem;
		}
		.recipient-mode label {
			display: flex;
			flex: 1 1 0;
			align-items: center;
			gap: .5rem;
			min-height: 52px;
			margin: 0;
			padding: .65rem 1rem;
			border: 1px solid #d8dde3;
			border-radius: 4px;
			background: #fff;
			cursor: pointer;
		}
		.recipient-mode label.active {
			border-color: var(--theme-color, #28a745);
			box-shadow: inset 0 0 0 1px var(--theme-color, #28a745);
		}
		.recipient-mode input {
			position: absolute;
			opacity: 0;
		}
		.recipient-mode i {
			color: var(--theme-color, #28a745);
		}
		.transfer-amount-panel {
			max-width: 600px;
		}
		.transfer-amount-input {
			display: flex;
			align-items: stretch;
			border: 1px solid #cfd5da;
			border-radius: 4px;
			background: #fff;
			overflow: hidden;
			transition: border-color .2s, box-shadow .2s;
		}
		.transfer-amount-input:focus-within {
			border-color: var(--theme-color, #28a745);
			box-shadow: 0 0 0 2px rgba(40, 167, 69, .12);
		}
		.transfer-amount-input.is-invalid {
			border-color: #dc3545;
		}
		.transfer-amount-input .transfer-amount-control {
			min-width: 0;
			height: 64px;
			min-height: 64px;
			padding: .75rem 1rem;
			border: 0 !important;
			border-radius: 0;
			box-shadow: none !important;
			font-size: 1.45rem;
			font-weight: 600;
		}
		.transfer-currency-code {
			display: flex;
			align-items: center;
			justify-content: center;
			min-width: 68px;
			padding: 0 .8rem;
			border-left: 1px solid #e1e5e9;
			background: #f6f7f8;
			color: #2d3339;
			font-weight: 700;
		}
		.transfer-balance-line {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 1rem;
			margin-top: .75rem;
			color: #6c757d;
			font-size: .86rem;
		}
		.transfer-balance-line strong {
			color: #2d3339;
			font-size: .9rem;
			white-space: nowrap;
		}
		.transfer-balance-error {
			margin: .65rem 0 0;
			color: #dc3545;
			font-size: .88rem;
			font-weight: 600;
		}
		.transfer-actions {
			display: flex;
			justify-content: flex-end;
			margin-top: 1.5rem;
			padding-top: 1.25rem;
			border-top: 1px solid #e7eaed;
		}
		@media (max-width: 575px) {
			.transfer-page .admin-heading {
				margin-bottom: 1rem;
			}
			.transfer-form {
				padding: .75rem !important;
			}
			.transfer-section {
				margin-bottom: 1rem;
				padding: 1.25rem 1rem;
			}
			.transfer-section-title {
				margin-bottom: 1.25rem;
			}
			.transfer-amount-input .transfer-amount-control {
				height: 58px;
				min-height: 58px;
				font-size: 1.3rem;
			}
			.transfer-currency-code {
				min-width: 54px;
				padding: 0 .6rem;
			}
			.transfer-balance-line {
				font-size: .8rem;
			}
			.recipient-mode {
				flex-direction: column;
			}
			.recipient-mode label {
				width: 100%;
			}
			.transfer-actions .btn {
				width: 100%;
				min-height: 50px;
			}
		}
	</style>
@endsection

@section('content')
	
	@livewire('add-transfer-form', [
		'transfert_ref_msg' => $transfert_ref_msg,
	])

@endsection
