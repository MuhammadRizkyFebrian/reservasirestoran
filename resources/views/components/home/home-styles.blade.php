<style>
@media (max-width: 640px) {
    .card-container {
        grid-template-columns: repeat(1, 1fr);
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    .card-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1025px) {
    .card-container {
        grid-template-columns: repeat(3, 1fr);
    }
}

.card-menu:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}

.hero-section {
    background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1074&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.rating {
    display: inline-flex;
    gap: 0.25rem;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
}

.star-icon {
    font-size: 1.5rem;
}

.review-form {
    display: none;
}

.review-form.active {
    display: block;
}

.promo-card {
    background-size: cover;
    background-position: center;
    height: 250px;
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
}

.promo-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0) 100%);
    z-index: 1;
}

.promo-content {
    position: relative;
    z-index: 2;
    padding: 1.5rem;
    width: 100%;
}
</style> 