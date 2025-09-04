document.addEventListener('DOMContentLoaded', function () {
    const sliders = document.querySelectorAll('.slider');
    let current = 1;
    sliders.forEach(slider => {
        slider.addEventListener('click', async function () {
            const step = parseInt(slider.dataset.step);
            if (step === current) {
                slider.classList.add('ok');
                current++;
                if (current > 3) {
                    // notify server
                    await fetch('/captcha/verifySlider', { method: 'POST' });
                    alert('Slider captcha completed ✅');
                }
            } else {
                alert('Please complete step ' + current + ' first');
            }
        });
    });
});
