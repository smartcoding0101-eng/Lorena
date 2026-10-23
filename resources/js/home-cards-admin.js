/**
 * Gestión de Tarjetas Dinámicas del Inicio (GardenHomeCards)
 * Permite al administrador crear, editar y eliminar tarjetas del inicio con múltiples diseños y pantallas de destino.
 */

export function initHomeCardsAdmin() {
    const modal = document.getElementById('admin-home-card-modal');
    const form = document.getElementById('admin-home-card-form');
    const btnAdd = document.getElementById('btn-add-home-card');
    const btnClose = document.getElementById('btn-close-home-card-modal');
    const btnCancel = document.getElementById('btn-cancel-home-card');

    if (!modal || !form) {
        return; // No es administrador autenticado
    }

    const modalTitle = document.getElementById('admin-home-card-modal-title');
    const saveBtnText = document.getElementById('btn-save-card-text');
    const cardIdInput = document.getElementById('home-card-id');
    const titleInput = document.getElementById('home-card-title');
    const emblemInput = document.getElementById('home-card-emblem');
    const subtitleInput = document.getElementById('home-card-subtitle');
    const orderInput = document.getElementById('home-card-order');
    const screenInput = document.getElementById('home-card-screen');
    const variantInput = document.getElementById('home-card-variant');
    const descInput = document.getElementById('home-card-desc');
    const quoteInput = document.getElementById('home-card-quote');

    const getCsrfToken = () => {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    };

    // Abrir modal para nueva tarjeta
    if (btnAdd) {
        btnAdd.addEventListener('click', () => {
            form.reset();
            cardIdInput.value = '';
            modalTitle.textContent = 'Nueva Tarjeta para el Inicio';
            saveBtnText.textContent = 'Guardar Tarjeta';
            
            // Sugerir siguiente orden
            const existingCards = document.querySelectorAll('#home-space-grid .space-card');
            orderInput.value = existingCards.length + 1;
            
            modal.showModal();
        });
    }

    // Cerrar modal
    if (btnClose) {
        btnClose.addEventListener('click', () => modal.close());
    }
    if (btnCancel) {
        btnCancel.addEventListener('click', () => modal.close());
    }

    modal.addEventListener('click', (e) => {
        const rect = modal.getBoundingClientRect();
        const isInDialog = (
            rect.top <= e.clientY &&
            e.clientY <= rect.top + rect.height &&
            rect.left <= e.clientX &&
            e.clientX <= rect.left + rect.width
        );
        if (!isInDialog) {
            modal.close();
        }
    });

    // Delegación de eventos para Editar y Eliminar
    const grid = document.getElementById('home-space-grid');
    if (grid) {
        grid.addEventListener('click', (e) => {
            const editBtn = e.target.closest('.btn-home-card-edit');
            const deleteBtn = e.target.closest('.btn-home-card-delete');

            if (editBtn) {
                e.preventDefault();
                e.stopPropagation();
                const card = editBtn.closest('.space-card');
                if (!card) return;

                cardIdInput.value = card.dataset.cardId || '';
                titleInput.value = card.dataset.cardTitle || '';
                emblemInput.value = card.dataset.cardIcon || '';
                subtitleInput.value = card.dataset.cardSubtitle || '';
                orderInput.value = card.dataset.cardOrder || '1';
                screenInput.value = card.dataset.cardScreen || 'galeria';
                variantInput.value = card.dataset.cardVariant || 'space-card-large';
                descInput.value = card.dataset.cardDesc || '';
                quoteInput.value = card.dataset.cardQuote || '';

                modalTitle.textContent = `Editar Tarjeta: ${card.dataset.cardTitle || ''}`;
                saveBtnText.textContent = 'Actualizar Tarjeta';
                modal.showModal();
                return;
            }

            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();
                const cardId = deleteBtn.dataset.id;
                const card = deleteBtn.closest('.space-card');
                const title = card ? card.dataset.cardTitle : 'esta tarjeta';

                if (!confirm(`¿Eliminar la tarjeta "${title}" del inicio?`)) {
                    return;
                }

                deleteBtn.disabled = true;
                deleteBtn.textContent = '⏳';

                fetch(`/admin/home-cards/${cardId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'No se pudo eliminar la tarjeta.');
                        deleteBtn.disabled = false;
                        deleteBtn.textContent = '🗑️';
                    }
                })
                .catch(err => {
                    console.error('Error al eliminar tarjeta:', err);
                    alert('Ocurrió un error al intentar eliminar la tarjeta.');
                    deleteBtn.disabled = false;
                    deleteBtn.textContent = '🗑️';
                });
            }
        });
    }

    // Guardar / Actualizar Tarjeta
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const cardId = cardIdInput.value;
        const isEditing = Boolean(cardId);
        const url = isEditing ? `/admin/home-cards/${cardId}` : '/admin/home-cards';
        const method = isEditing ? 'PUT' : 'POST';

        const payload = {
            title: titleInput.value.trim(),
            subtitle: subtitleInput.value.trim(),
            emblem_icon: emblemInput.value.trim(),
            sort_order: parseInt(orderInput.value, 10) || 1,
            target_screen: screenInput.value,
            style_variant: variantInput.value,
            description: descInput.value.trim(),
            quote: quoteInput.value.trim(),
            is_active: 1,
        };

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        const originalText = saveBtnText.textContent;
        saveBtnText.textContent = 'Guardando...';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify(payload),
        })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) {
                const msg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Error en la petición');
                throw new Error(msg);
            }
            return data;
        })
        .then(data => {
            modal.close();
            window.location.reload();
        })
        .catch(err => {
            console.error('Error al guardar tarjeta:', err);
            alert(err.message || 'Ocurrió un error al guardar la tarjeta.');
            submitBtn.disabled = false;
            saveBtnText.textContent = originalText;
        });
    });
}
