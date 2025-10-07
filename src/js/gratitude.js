/**
 * Gratitude Gallery JavaScript
 * Handles lightbox and interactive features
 */

class GratitudeGallery {
    constructor() {
        this.galleryGrid = document.getElementById('galleryGrid');
        this.lightbox = document.getElementById('lightbox');
        this.lightboxImage = document.querySelector('.lightbox__image');
        this.lightboxTitle = document.querySelector('.lightbox__title');
        this.lightboxDescription = document.querySelector('.lightbox__description');
        this.loadMoreBtn = document.getElementById('loadMoreBtn');
        this.yearFilters = document.getElementById('yearFilters');
        
        this.allItems = [];
        this.currentItems = [];
        this.currentIndex = 0;
        this.itemsPerPage = 8;
        this.currentPage = 1;
        this.currentYear = 'all';
        
        this.init();
    }
    
    init() {
        this.collectItems();
        this.bindEvents();
        this.bindFilterEvents();
        this.showItems();
    }
    
    collectItems() {
        this.allItems = Array.from(document.querySelectorAll('.gratitude-item'));
        this.currentItems = [...this.allItems];
    }
    
    bindFilterEvents() {
        if (this.yearFilters) {
            const filterButtons = this.yearFilters.querySelectorAll('.gratitude-filter-btn');
            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active state
                    filterButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    // Filter items
                    const year = btn.dataset.year;
                    this.currentYear = year;
                    this.filterByYear(year);
                });
            });
        }
    }
    
    filterByYear(year) {
        if (year === 'all') {
            this.currentItems = [...this.allItems];
        } else {
            this.currentItems = this.allItems.filter(item => item.dataset.year === year);
        }
        
        // Reset pagination
        this.currentPage = 1;
        
        // Rebind events for filtered items
        this.bindEvents();
        
        // Animate filter
        this.animateFilter();
    }
    
    animateFilter() {
        // Fade out
        this.allItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
        });
        
        setTimeout(() => {
            this.showItems();
            
            // Fade in filtered items
            setTimeout(() => {
                this.currentItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * 50);
                });
            }, 50);
        }, 300);
    }
    
    bindEvents() {
        // Lightbox events - click on entire card
        this.currentItems.forEach((item, index) => {
            // Click on entire card
            item.addEventListener('click', (e) => {
                // Don't trigger if clicking on zoom button
                if (e.target.closest('.gratitude-item__zoom-btn')) {
                    return;
                }
                this.openLightbox(index);
            });
            
            // Keep zoom button functionality for accessibility
            const zoomBtn = item.querySelector('.gratitude-item__zoom-btn');
            zoomBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.openLightbox(index);
            });
        });
        
        // Lightbox navigation
        document.querySelector('.lightbox__close').addEventListener('click', (e) => {
            e.stopPropagation();
            this.closeLightbox();
        });
        document.querySelector('.lightbox__overlay').addEventListener('click', () => this.closeLightbox());
        
        // Close on click outside image (on content area)
        document.querySelector('.lightbox__content').addEventListener('click', (e) => {
            // Only close if clicking on the content itself, not on image or buttons
            if (e.target.classList.contains('lightbox__content')) {
                this.closeLightbox();
            }
        });
        
        // Prevent closing when clicking on the image itself
        document.querySelector('.lightbox__image').addEventListener('click', (e) => {
            e.stopPropagation();
        });
        
        document.querySelector('.lightbox__prev').addEventListener('click', (e) => {
            e.stopPropagation();
            this.prevImage();
        });
        document.querySelector('.lightbox__next').addEventListener('click', (e) => {
            e.stopPropagation();
            this.nextImage();
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!this.lightbox.classList.contains('active')) return;
            
            switch(e.key) {
                case 'Escape':
                    this.closeLightbox();
                    break;
                case 'ArrowLeft':
                    this.prevImage();
                    break;
                case 'ArrowRight':
                    this.nextImage();
                    break;
            }
        });
        
        // Load more button
        this.loadMoreBtn.addEventListener('click', () => this.loadMore());
    }
    
    
    showItems() {
        // Hide all items
        this.currentItems.forEach(item => {
            item.style.display = 'none';
        });
        
        // Show items for current page
        const startIndex = 0;
        const endIndex = Math.min(this.currentPage * this.itemsPerPage, this.currentItems.length);
        
        for (let i = startIndex; i < endIndex; i++) {
            if (this.currentItems[i]) {
                this.currentItems[i].style.display = 'block';
            }
        }
        
        // Update load more button
        this.updateLoadMoreButton();
    }
    
    loadMore() {
        this.currentPage++;
        this.showItems();
    }
    
    updateLoadMoreButton() {
        const totalItems = this.currentItems.length;
        const visibleItems = this.currentPage * this.itemsPerPage;
        
        if (visibleItems >= totalItems) {
            this.loadMoreBtn.style.display = 'none';
        } else {
            this.loadMoreBtn.style.display = 'inline-flex';
        }
    }
    
    openLightbox(index) {
        // Find the item in current items
        const item = this.currentItems[index];
        if (!item) return;
        
        const img = item.querySelector('.gratitude-item__image img');
        const title = item.querySelector('.gratitude-item__title').textContent;
        const description = item.querySelector('.gratitude-item__description').textContent;
        
        this.currentIndex = index;
        
        this.lightboxImage.src = img.src;
        this.lightboxImage.alt = img.alt;
        this.lightboxTitle.textContent = title;
        this.lightboxDescription.textContent = description;
        
        this.lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        this.updateLightboxNavigation();
    }
    
    closeLightbox() {
        this.lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    prevImage() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.currentItems.length - 1;
        }
        this.updateLightboxImage();
    }
    
    nextImage() {
        if (this.currentIndex < this.currentItems.length - 1) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0;
        }
        this.updateLightboxImage();
    }
    
    updateLightboxImage() {
        const item = this.currentItems[this.currentIndex];
        const img = item.querySelector('.gratitude-item__image img');
        const title = item.querySelector('.gratitude-item__title').textContent;
        const description = item.querySelector('.gratitude-item__description').textContent;
        
        this.lightboxImage.src = img.src;
        this.lightboxImage.alt = img.alt;
        this.lightboxTitle.textContent = title;
        this.lightboxDescription.textContent = description;
    }
    
    updateLightboxNavigation() {
        const prevBtn = document.querySelector('.lightbox__prev');
        const nextBtn = document.querySelector('.lightbox__next');
        
        // Show/hide navigation buttons based on item count
        if (this.currentItems.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'flex';
            nextBtn.style.display = 'flex';
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new GratitudeGallery();
});

// Add some smooth animations
document.addEventListener('DOMContentLoaded', () => {
    // Animate items on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all gratitude items
    document.querySelectorAll('.gratitude-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(item);
    });
    
    // Animate statistics counters
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('.gratitude-stats__number').forEach(counter => {
        statsObserver.observe(counter);
    });
});

// Counter animation function
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000; // 2 seconds
    const increment = target / (duration / 16); // 60fps
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}
