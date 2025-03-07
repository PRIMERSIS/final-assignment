// Lấy các phần tử cần thiết
const giảiPháp = document.getElementById('giảiPháp');
const megaMenu = document.getElementById('megaMenu');
const header = document.querySelector('.header'); // Lấy phần tử header

// Thêm sự kiện mouseenter và mouseleave vào "Giải pháp"
giảiPháp.addEventListener('mouseenter', function() {
    megaMenu.style.display = 'flex'; // Hiển thị mega menu
    header.style.backgroundColor = '#010101'; // Đổi màu nền của header theo màu Mega Menu
    // Thay đổi màu chữ của các phần tử trong header khi hover vào "Giải pháp"
    const navLinks = document.querySelectorAll('.nav ul li a');
    navLinks.forEach(link => {
        link.style.color = '#00b46f'; // Đổi màu chữ thành trắng khi hover vào "Giải pháp"
    });
});

// Thêm sự kiện mouseleave vào "Giải pháp"
giảiPháp.addEventListener('mouseleave', function() {
    setTimeout(function() {
        if (!megaMenu.matches(':hover')) {
            megaMenu.style.display = 'none';
            header.style.backgroundColor = ''; // Đặt lại màu nền của header về mặc định
            // Đổi lại màu chữ của các liên kết trong header khi không hover vào "Giải pháp"
            const navLinks = document.querySelectorAll('.nav ul li a');
            navLinks.forEach(link => {
                link.style.color = '#000'; // Đổi màu chữ trở lại đen khi không hover
            });
        }
    }, 200);
});



// Thêm sự kiện mouseenter và mouseleave vào Mega Menu
megaMenu.addEventListener('mouseenter', function() {
    megaMenu.style.display = 'flex'; // Giữ Mega Menu hiển thị khi chuột hover vào Mega Menu
    header.style.backgroundColor = '#010101'; // Giữ màu nền của header khi hover vào Mega Menu
});

megaMenu.addEventListener('mouseleave', function() {
    megaMenu.style.display = 'none'; // Ẩn Mega Menu khi chuột ra khỏi Mega Menu
    header.style.backgroundColor = ''; // Đặt lại màu nền của header về mặc định
    // Đổi lại màu chữ của các liên kết trong header khi không hover vào Mega Menu
    const navLinks = document.querySelectorAll('.nav ul li a');
    navLinks.forEach(link => {
        link.style.color = '#d9f6eb'; // Đổi màu chữ trở lại đen khi không hover
    });
});


// //hàm để thêm sản phẩm mới
// function addProduct(product) {
//     const productGrid = document.querySelector('.product-grid');
//     const productCard = document.createElement('div');
//     productCard.classList.add('product-card');
  
//     // Chèn sản phẩm vào bên trong thẻ product-card
//     productCard.innerHTML = `
//       <div class="containerimg">
//         <span class="img_item">
//           <img src="${product.imgUrl}" alt="${product.name}">
//         </span>
//       </div>
//       <div class="product-info">
//         <h3>${product.name}</h3>
//         <div class="price">${product.price}</div>
//         <div class="button-container">
//           <li><a href="#" class="btn">Xem thử</a></li>
//           <li><a href="#" class="btn">Chi tiết</a></li>
//         </div>
//       </div>
//     `;
    
    
//     productGrid.appendChild(productCard);
//   }
  
//   // Ví dụ sử dụng hàm thêm sản phẩm
//   addProduct({
//     name: 'F1GENZ Beauty Cosmetic',
//     imgUrl: '213c586e6ed5602828b95df8e7d8e4fa.jpg',
//     price: '2,400,000đ'
//   });
//   addProduct({
//     name: 'F1GENZ Beauty Cosmetic',
//     imgUrl: 'e43b0048a347b052e36d41b022574213.jpg',
//     price: '2,400,000đ'
//   });
//   addProduct({
//     name: 'F1GENZ Beauty Cosmetic',
//     imgUrl: 'e43b0048a347b052e36d41b022574213.jpg',
//     price: '2,400,000đ'
//   });
//   addProduct({
//     name: 'F1GENZ Beauty Cosmetic',
//     imgUrl: 'e43b0048a347b052e36d41b022574213.jpg',
//     price: '2,400,000đ'
//   });
//   addProduct({
//     name: 'F1GENZ Beauty Cosmetic',
//     imgUrl: 'e43b0048a347b052e36d41b022574213.jpg',
//     price: '2,400,000đ'
//   }); 


// Lấy tất cả các item trong sort bar
const sortItems = document.querySelectorAll('.sort-item');  

// Lặp qua tất cả các item và gán sự kiện click
sortItems.forEach(item => {
  item.addEventListener('click', function() {
    // Xóa lớp "selected" khỏi tất cả các item
    sortItems.forEach(i => i.classList.remove('selected'));
    
    // Thêm lớp "selected" vào mục đã chọn
    this.classList.add('selected');
  });
});

// Lấy danh sách tất cả các nút
const buttons = document.querySelectorAll('.btn');

// Thêm sự kiện hover cho mỗi nút
buttons.forEach(button => {
  button.addEventListener('mouseenter', () => {
    button.classList.add('hovering'); // Thêm hiệu ứng hover
  });

  button.addEventListener('mouseleave', () => {
    button.classList.remove('hovering'); // Xóa hiệu ứng hover
  });
});

