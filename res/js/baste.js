$(document).ready(function () {
    // first, find all the div.code blocks
    document.querySelectorAll('div.code').forEach(el => {
        // then highlight each
        hljs.highlightElement(el);
    });
})