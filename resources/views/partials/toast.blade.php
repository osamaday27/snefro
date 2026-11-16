<script>
    if (!window.__snefroToastBound) {
        window.__snefroToastBound = true;
        document.addEventListener('livewire:init', () => {
            Livewire.on('toast', (e) => {
                const d = Array.isArray(e) ? e[0] : e;
                Swal.fire({
                    toast: true, position: 'top', icon: d.type || 'success', title: d.message,
                    showConfirmButton: false, timer: 2400, timerProgressBar: true, heightAuto: false,
                });
            });
        });
    }
</script>
