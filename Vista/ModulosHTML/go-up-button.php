

<div class="go-up-button">
    <a href="#ha" title="Regresar arriba">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M625-46Q479-88 388.5-208.5T298-481q0-86 31-165t89-142H296v-126h329v329H499v-102q-37 44-56 97t-19 110q0 99 54.5 180.5T625-180v134Z"/></svg>
    </a>
</div>

<!-- TOOLTIPS PASSWORD -->
<script>
    document.querySelectorAll('a[title]').forEach((a) => {
        const title = a.getAttribute('title');
        a.removeAttribute('title');
        tippy(a, {
            content: title,
            arrow: true,
            animation: 'fade',
        });
    });
</script>
