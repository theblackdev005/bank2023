@section('script')
    @if( $errors->any() )
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            @php
                $type = $errors->has('success');
            @endphp
            (function () {
                Swal.fire({
                  icon: '{{ $type ? 'success' : 'error' }}',
                  title: '{{ $type ? 'Super !' : 'Oops...' }}',
                  text: '{{ $errors->first() }}',
                })
            })();
        </script>
    @endif
@endsection