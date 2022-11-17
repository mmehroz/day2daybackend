@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <script>
                window.onload = function() {
                    md.showNotification('top','right', '{{ $msg }}', 'success');
                };
            </script>
        @endforeach
    @else
        <script>
            window.onload = function() {
                md.showNotification('top','right', '{{ $data }}', 'success');
            };
        </script>
    @endif
@endif

