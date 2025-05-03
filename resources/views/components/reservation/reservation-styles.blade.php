<style>
.table-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    margin: 0.25rem;
    cursor: pointer;
    transition: all 0.2s;
}

.table-btn.available {
    background-color: #86efac;
    border: 1px solid #22c55e;
}

.table-btn.reserved {
    background-color: #fca5a5;
    border: 1px solid #ef4444;
    cursor: not-allowed;
    opacity: 0.8;
}

.table-btn.selected {
    background-color: #93c5fd;
    border: 1px solid #3b82f6;
    transform: scale(1.05);
}

.table-btn.available:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.5rem;
    margin-top: 1rem;
}

.payment-method {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid var(--fallback-border-color,oklch(var(--bc)/0.2));
    cursor: pointer;
    transition: all 0.2s;
}

.payment-method:hover, .payment-method.active {
    border-color: var(--fallback-primary,oklch(var(--p)));
    background-color: var(--fallback-primary,oklch(var(--p)/0.1));
}

.payment-method img {
    width: 48px;
    height: 32px;
    object-fit: contain;
    margin-right: 0.75rem;
}

@media (max-width: 640px) {
    .table-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }
}
</style> 