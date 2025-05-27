# Pais Digital - Advanced Landing Page

A professional, responsive one-page landing page built with modern web technologies, featuring advanced JavaScript functionality, custom CSS with brand colors, and comprehensive form validation. Built for Pais Digital to showcase digital excellence and innovation.

## 🚀 Features

### **Design & Branding**
- **Pais Digital Brand Colors**: Complete color scheme implementation
- **Modern Typography**: Inter font family for professional appearance
- **Responsive Design**: Mobile-first approach with Bootstrap 5
- **Advanced Animations**: Scroll-triggered animations and particle effects
- **Interactive Elements**: Hover effects and smooth transitions

### **Technical Features**
- **Separated Architecture**: Organized CSS and JavaScript files
- **Advanced JavaScript**: ES6+ features with class-based architecture
- **Real-time Validation**: Both client-side and server-side validation
- **Progress Bar**: Visual scroll progress indicator
- **Particle System**: Animated background particles in hero section
- **Parallax Effects**: Smooth scrolling parallax animations
- **Performance Optimized**: Lazy loading and throttled event handlers

### **Form Functionality**
- **Dual Validation**: Frontend (JavaScript) + Backend (PHP)
- **Real-time Feedback**: Live validation as users type
- **Character Counter**: Dynamic character count for textarea
- **Enhanced UX**: Form shake animation on errors
- **Security**: Input sanitization and XSS protection

### **Advanced JavaScript Features**
- **Class-based Architecture**: Modern OOP approach
- **Event Management**: Throttled scroll and debounced input events
- **Animation System**: Intersection Observer for scroll animations
- **Keyboard Navigation**: Accessibility-focused keyboard shortcuts
- **Mobile Optimization**: Responsive particle count adjustment
- **Error Handling**: Comprehensive error management

## 🛠 Technologies Used

- **Frontend**: HTML5, CSS3 (Custom Variables), JavaScript (ES6+)
- **Framework**: Bootstrap 5.3.0
- **Backend**: PHP 8.1 with Apache
- **Fonts**: Google Fonts (Inter)
- **Icons**: Font Awesome
- **Container**: Docker & Docker Compose

## 📁 Project Structure

```
.
├── docker-compose.yml          # Docker services configuration
├── Dockerfile                 # PHP Apache container setup
├── index.php                  # Main landing page with PHP backend
├── assets/
│   ├── css/
│   │   └── style.css          # Advanced CSS with brand colors
│   ├── js/
│   │   └── main.js            # Advanced JavaScript functionality
│   └── images/                # Image assets directory
└── README.md                  # This documentation
```

## 🎨 Brand Colors & Design System

### **Color Palette**
- **Primary**: `#2c5aa0` (Pais Digital Blue)
- **Secondary**: `#1e3d6f` (Dark Blue)
- **Accent**: `#4a90e2` (Light Blue)
- **Background**: `#e8f4fd` (Light Blue Background)
- **Text Primary**: `#2c3e50`
- **Text Secondary**: `#5a6c7d`

### **Design Features**
- **CSS Custom Properties**: Consistent theming throughout
- **Gradient Backgrounds**: Brand-consistent gradients
- **Box Shadows**: Layered shadow system for depth
- **Border Radius**: Consistent 8px/12px radius system
- **Transitions**: Smooth cubic-bezier animations

## 🚀 Quick Start

### **Prerequisites**
- Docker Desktop
- Docker Compose

### **Installation & Setup**

1. **Clone or download this project**
2. **Navigate to the project directory**
3. **Build and start the Docker containers:**

```bash
docker-compose up --build
```

4. **Open your browser and visit:**
   - `http://localhost:8080`
   - `http://127.0.0.1:8080`

### **Stopping the Application**

```bash
docker-compose down
```

## 🔧 Advanced Features

### **JavaScript Functionality**
- **PaisDigitalApp Class**: Main application controller
- **Form Validation**: Advanced validation with custom rules
- **Animation System**: Scroll-triggered animations
- **Particle System**: Dynamic particle generation
- **Progress Tracking**: Visual scroll progress
- **Event Optimization**: Throttled and debounced events

### **CSS Features**
- **CSS Variables**: Comprehensive design token system
- **Advanced Animations**: Keyframe animations for particles and elements
- **Responsive Design**: Mobile-first breakpoints
- **Custom Scrollbar**: Branded scrollbar styling
- **Interactive States**: Hover and focus states for all elements

### **Form Validation Rules**
- **Full Name**: Required, letters and spaces only, minimum 2 characters
- **Email**: Required, valid email format
- **Phone**: Required, minimum 10 digits, international format support
- **Country**: Required selection from dropdown
- **Message**: Required, 10-1000 characters with live counter

## 🎯 Performance Features

- **Optimized Loading**: Preconnect to external resources
- **Lazy Loading**: Intersection Observer for images
- **Event Throttling**: Optimized scroll and resize handlers
- **Mobile Optimization**: Reduced particle count on mobile devices
- **Efficient Animations**: Hardware-accelerated CSS transforms

## 🔒 Security Features

- **Input Sanitization**: All form inputs are sanitized
- **XSS Protection**: HTML special characters escaped
- **CSRF Protection**: Form validation tokens (ready for implementation)
- **Server-side Validation**: Comprehensive PHP validation
- **Error Logging**: Secure error logging for debugging

## 📱 Browser Support

- **Chrome**: Latest (recommended)
- **Firefox**: Latest
- **Safari**: Latest
- **Edge**: Latest
- **Mobile**: iOS Safari, Chrome Mobile

## 🎨 Customization

### **Brand Colors**
Modify the CSS custom properties in `assets/css/style.css`:
```css
:root {
    --primary-color: #2c5aa0;
    --secondary-color: #1e3d6f;
    /* ... other colors */
}
```

### **Content Updates**
- Update text content in `index.php`
- Replace logo URL with your own
- Modify service offerings and features

### **JavaScript Customization**
- Adjust animation timings in `assets/js/main.js`
- Modify validation rules in the `validateForm` method
- Customize particle count and behavior

## 🚀 Deployment

### **Production Considerations**
1. **Environment Variables**: Set up proper environment configuration
2. **SSL Certificate**: Configure HTTPS for production
3. **Database Integration**: Replace form logging with database storage
4. **Email Integration**: Set up SMTP for form submissions
5. **CDN**: Consider CDN for static assets
6. **Monitoring**: Implement error tracking and analytics

### **Docker Production**
```bash
# Build for production
docker-compose -f docker-compose.prod.yml up --build -d
```

## 📄 License

This project is developed for Pais Digital. All rights reserved.

---

**Developed with ❤️ for Pais Digital - Empowering Digital Excellence** 