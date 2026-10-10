document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('cartToast');
    let toastTimeout;

    function showToast(message, isError = false) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.toggle('cart-toast--error', isError);
        toast.classList.add('is-visible');
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => toast.classList.remove('is-visible'), 2500);
    }

    function updateCartCount(count) {
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
        });
    }

    document.addEventListener('submit', async (e) => {
        const form = e.target;

        if (!form.matches('form[action*="/cart/add/"]')) return;

        e.preventDefault();

        const button = form.querySelector('button[type="submit"]');
        const originalContent = button ? button.innerHTML : null;
        if (button) {
            button.disabled = true;
            button.dataset.originalContent = originalContent;
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: new FormData(form),
            });

            const data = await response.json();

            if (!response.ok) {
                showToast(data.message || 'Something went wrong — please try again.', true);
                return;
            }

            updateCartCount(data.cartCount);
            showToast(data.message);
        } catch (err) {
            showToast('Could not add to cart — check your connection.', true);
        } finally {
            if (button) {
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        }
    });
});