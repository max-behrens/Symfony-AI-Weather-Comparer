import './bootstrap.js';
import './styles/app.css';

// Import Turbo correctly - no named export
import * as Turbo from '@hotwired/turbo';

// Initialize Turbo
Turbo.start();

console.log('Turbo initialized successfully!');