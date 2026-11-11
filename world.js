document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('country');
    const result = document.getElementById('result');

    function search(extra = '') {
        const country = encodeURIComponent(input.value.trim());
        fetch(`world.php?country=${country}${extra}`)
            .then(response => response.text())
            .then(html => { result.innerHTML = html; })
            .catch(error => { result.textContent = 'Error: ' + error; });
    }

    document.getElementById('lookup').addEventListener('click', () => search());
    document.getElementById('lookup-cities').addEventListener('click', () => search('&lookup=cities'));
});