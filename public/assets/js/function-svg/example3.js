// $(function () {
let svgExample3 = "{{ asset('assets/images/svg/example3.svg') }}";
scadavisInit({
    container: 'example3-svg',
    svgurl: svgExample3
}).then(sv => {
    sv.enableMouse(true, true);
    sv.setValue("TAG1", 0);
    // update at each .25 seconds
    setInterval(function () {
        var v = Math.random() * 10 - 2.5 * sv.getValue("TAG1") / 60 + sv.getValue(
            "TAG1");
        if (v < 0) v = 0;
        if (v > 120) v = 120;
        sv.setValue("TAG1", v);
    }, 250);
})
// });