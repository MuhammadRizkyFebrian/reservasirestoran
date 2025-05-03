<style>
.hero-section {
    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=2070&auto=format&fit=crop');
}

.menu-item-card {
    transition: transform 0.3s ease;
}

.menu-item-card:hover {
    transform: translateY(-5px);
}

.badge-tag {
    background-color: #e2e8f0;
    color: #4b5563;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Menghilangkan panah dropdown bawaan browser */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: none !important;
}

/* Untuk Firefox */
select::-ms-expand {
    display: none;
}
</style> 