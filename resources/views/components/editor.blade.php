@props(['id', 'model', 'value'])
<textarea class="form-control" data-description="@this" id="{{$id}}" cols="30" rows="10">{!!$value!!}</textarea>
@push('script')
<script>
    ClassicEditor
        .create(document.querySelector('#{{$id}}'))
        .then(editor => {
            document.querySelector('#submit').addEventListener('click', function() {
                let data = $("#{{$id}}").data('description');
                eval(data).set('{{$model}}', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush