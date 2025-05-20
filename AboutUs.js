document.addEventListener("DOMContentLoaded", function () {
    const aboutSection = document.getElementById("about-section");
  
    const content = `
      <p>Welcome to <strong>Lotus Fire</strong> – where tradition meets taste. 
      We're an independent Asian restaurant located in Sliema, 
      dedicated to serving authentic, flavour-packed cuisine crafted with the freshest ingredients.</p>
      
      <p>We believe food is not just about taste — it's about story, culture, and sharing. 
      Come join us on a journey through flavour!</p>
      
      <p><em>Welcome to our restaurant!.</em></p>
    `;
  
    aboutSection.innerHTML = content;
  });