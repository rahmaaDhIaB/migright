document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function () {
            const demandId = this.dataset.demandId;
            const reasons = [
                'Reason 1',
                'Reason 2',
                'Reason 3',
            ];

            let reasonOptions = reasons.map(reason => `<option value="${reason}">${reason}</option>`).join('');

            let modalContent = `
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Annuler la demande</h2>
                        <form id="cancel-form">
                            <label for="reason">Sélectionner la raison de l'annulation:</label>
                            <select id="reason" name="cancellation_reason" required>
                                ${reasonOptions}
                            </select>
                            <button type="submit">Soumettre</button>
                        </form>
                    </div>
                </div>
            `;

            let modal = document.createElement('div');
            modal.innerHTML = modalContent;
            document.body.appendChild(modal);

            modal.querySelector('.close').addEventListener('click', () => {
                modal.remove();
            });

            modal.querySelector('#cancel-form').addEventListener('submit', function (event) {
                event.preventDefault();
                let reason = this.querySelector('#reason').value;

                fetch(`/api/demands/${demandId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cancellation_reason: reason })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    modal.remove();
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
});
