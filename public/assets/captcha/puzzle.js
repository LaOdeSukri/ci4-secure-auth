document.addEventListener('DOMContentLoaded', function () {
    const piece = document.getElementById('pieceImg');
    const box = document.getElementById('puzzleBox');
    if (!piece || !box) return;

    let offsetX = 0;
    piece.addEventListener('dragstart', function (e) { offsetX = e.offsetX || 0; });
    box.addEventListener('dragover', function (e) { e.preventDefault(); });
    box.addEventListener('drop', async function (e) {
        e.preventDefault();
        const rect = box.getBoundingClientRect();
        let posX = Math.round(e.clientX - rect.left - offsetX);
        if (posX < 0) posX = 0;
        if (posX > rect.width - piece.width) posX = rect.width - piece.width;
        piece.style.left = posX + 'px';
        // send to server verify current step (demo uses step 1)
        const fd = new FormData();
        fd.append('step', 1);
        fd.append('posX', posX);
        const res = await fetch('/captcha/verifyPuzzle', { method: 'POST', body: fd });
        const data = await res.json();
        const status = document.getElementById('puzzleStatus');
        if (data.status === 'ok') {
            status.textContent = 'Puzzle correct!';
        } else {
            status.textContent = data.message || 'Wrong, try again';
        }
    });
});
