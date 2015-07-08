@extends ('install._layout')

@section('content')
    <h1>License Agreement</h1>

    <textarea name="" id="" cols="30" rows="10">{{ $license_text }}</textarea>

    <p>
        <input type="checkbox" name="agreement" id="agreement"> I have read and understood the agreement
    </p>

    <p class="step">
        <input type="submit" value="Continue" id="continue" class="button button-large button-disabled" disabled>
    </p>
@stop

@section('scripts')
    <script>
        var agreement = document.getElementById('agreement'),
            continueBtn = document.getElementById('continue');

        agreement.addEventListener('click', function() {

            if (this.checked) {
                // enable the continue button
                continueBtn.className = continueBtn.className.replace(/\bbutton-disabled\b/,'');

                continueBtn.removeAttribute('disabled');
            } else {
                // disable the continue button
                continueBtn.className += ' button-disabled';

                continueBtn.setAttribute('disabled', true);
            }

        });

        continueBtn.addEventListener('click', function() {

            // go to next step when continue button is clicked
            var location = window.location.href.replace(/\/?$/, '/');
            window.location.href = location + '1';

        });
    </script>
@stop
