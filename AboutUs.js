document.addEventListener("DOMContentLoaded", function () {
    const aboutSection = document.getElementById("about-section");
  
    const content = `
      <p>Welcome to <strong>Lotus Fire</strong> – where tradition meets taste. 
      We're an independent Indian restaurant located in the heart of the city, 
      dedicated to serving authentic, flavour-packed cuisine crafted with the freshest ingredients.</p>
      
      <p>Founded in 2023, our mission is to celebrate India's culinary diversity — from 
      spicy street food to royal Mughlai dishes — in a warm, modern space.</p>
  
      <p>We believe food is not just about taste — it's about story, culture, and sharing. 
      Come join us on a journey through flavour!</p>
      
      <p><em>Namaste and welcome to our table.</em></p>
    `;
  
    aboutSection.innerHTML = content;
  });