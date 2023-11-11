<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/morph@3.x.x/dist/cdn.min.js"></script>

<!-- Alpine Core -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

    @livewire(App\Livewire\Counter::class)

    <script>
        document.querySelectorAll('[wire\\:snapshot]').forEach(el => {
            el.__livewire = JSON.parse(el.getAttribute('wire:snapshot')) // Spiegazione

            initWireClick(el)
        })

        function initWireClick(el) {
            el.addEventListener('click', e => {
                if (!e.target.hasAttribute('wire:click')) return

                let method = e.target.getAttribute('wire:click')

                sendRequest(el, { callMethod: method })
            })
        }

        function sendRequest(el, payload) {
            let snapshot = el.__livewire;

            fetch('/livewire', {
                method: 'POST',
                headers: { 'Content-type': 'Application/json'},
                body: JSON.stringify({
                    snapshot,
                    ...payload
                })
            }).then(i => i.json()).then(response => {
                   let { html, snapshot } = response

                    el.__livewire = snapshot

                    Alpine.morph(el.firstElementChild, html)
                    // el.innerHTML = html
                })
        }
    </script>
</html>



