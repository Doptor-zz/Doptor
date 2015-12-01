<script>
    @if ($errors->has())
        // Set the previously set data, if validation error
        $('#json-data').html(sessionStorage.formbuilder_form);
    @else if (!isset($form))
        // If no errors and not editing form, then form is empty
        $('#json-data').html('');
    @endif
</script>
{!! HTML::script('assets/backend/default/plugins/bootstrap-formbuilder/js/lib/require.js', ['data-main'=> URL::to('assets/backend/default/plugins/bootstrap-formbuilder/js/main-built.js')]) !!}

@parent

<script>
    function base64_encode(data) {
        var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
        var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = '',
        tmp_arr = [];

        if (!data) {
            return data;
        }

        do { // pack three octets into four hexets
            o1 = data.charCodeAt(i++);
            o2 = data.charCodeAt(i++);
            o3 = data.charCodeAt(i++);

            bits = o1 << 16 | o2 << 8 | o3;

            h1 = bits >> 18 & 0x3f;
            h2 = bits >> 12 & 0x3f;
            h3 = bits >> 6 & 0x3f;
            h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
        } while (i < data.length);

        enc = tmp_arr.join('');

        var r = data.length % 3;

        return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
    }
    jQuery(document).ready(function () {

        setInterval(function() {
           if ($('#formtabs li').length != 0) {
                $('#formtabs li').last().html('');
            }
        }, 1000);

        $("#container").addClass("sidebar-closed");
        $("#form-builder").on('submit', function (e) {

            $('#form-builder #form-name').val($('#target legend').html());

            var form_data = $("#render").val(),
                json_data = $('#json-data').val();

            sessionStorage.setItem('formbuilder_form', json_data);

            {{--Encode the form html to base64, so that firewalls will not detect it as attack--}}
            $('#form-builder #form-data').val(base64_encode(form_data));
            $('[name="extra_code"]').val(base64_encode($('[name="extra_code"]').val()));
        });
    });
</script>
