<!-- [ footer apps ] start -->
<footer class="footer">
    <div class="container title mb-0">
        <div class="row align-items-center">
            <div class="col-md-8">
                </div>
            <div class="col-md-4">
            </div>
            </div>
        </div>
    </div>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ URL::asset('build/images/logo-dark.svg') }}" alt="image"
                        class="footer-logo img-fluid mb-3" />
                    <p class="mb-4">{{ $website_footer_description->value ?? '' }}</p>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col my-1">
                    <p class="m-0">{{ $website_made_by_text->value ?? '' }}</p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-sos-link mb-0">
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- [ footer apps ] End -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ URL::asset('build/js/plugins/clipboard.min.js') }}"></script>
<script src="{{ URL::asset('build/js/component.js') }}"></script>
<script>
    // pc-component
    var elem = document.querySelectorAll('.component-list-card a');
    for (var l = 0; l < elem.length; l++) {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (elem[l].href == pageUrl && elem[l].getAttribute('href') != '') {
            elem[l].classList.add('active');
        }
    }
    document.querySelector('#compo-menu-search').addEventListener('keyup', function() {
        var tval = document.querySelector('#compo-menu-search').value.toLowerCase();
        var elem = document.querySelectorAll('.component-list-card a');
        for (var l = 0; l < elem.length; l++) {
            var aval = elem[l].innerHTML.toLowerCase();
            var n = aval.indexOf(tval);
            if (n !== -1) {
                elem[l].style.display = 'block';
            } else {
                elem[l].style.display = 'none';
            }
        }
    });
</script>