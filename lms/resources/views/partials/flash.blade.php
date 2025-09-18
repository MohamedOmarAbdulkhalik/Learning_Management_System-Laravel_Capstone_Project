    <script>
document.addEventListener('DOMContentLoaded', function(){
    const success = @json(session('success'));
    const error = @json(session('error'));

    function showToast(message, bg = '#16a34a') {
        if(!message) return;
        const el = document.createElement('div');
        el.innerText = message;
        el.style.position = 'fixed';
        el.style.right = '20px';
        el.style.top = '20px';
        el.style.padding = '10px 14px';
        el.style.background = bg;
        el.style.color = 'white';
        el.style.borderRadius = '6px';
        el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
        el.style.zIndex = 9999;
        document.body.appendChild(el);
        setTimeout(()=> el.remove(), 4000);
    }

    if(success) showToast(success, '#16a34a'); // أخضر
    if(error) showToast(error, '#dc2626');     // أحمر
});
</script>
