# Đồ án cuối kỳ môn Lập trình Wen và Ứng dụng
## About the project
- Đây là 1 trang web đặt vé xem phim cung cấp các chức năng tìm kiếm thông tin về phim, xuất chiếu, khuyến mãi và đặt vé, thanh toán online cho Khách hàng. Các chức năng quản lý phim, suất chiếu, đặt vé, tài khoản khách hàng, menu, khuyến mãi và thống kê doanh thu. 
- Trang web được xây dựng bằng HTML, CSS, Javascript, Boostrap, MySQL và PHP.
## Danh sách thành viên
- Ngô Chí Cường - 52100778
- Bùi Quang Thịnh - 52100584 
- Kiều Cao Minh Kiệt - 52100811 
- Huỳnh Nhật Linh - 52100815
- Phùng Thị Thủy Tiên - 52100846
## Software Development Principles, Patterns, and Practices
Model-View-Controller (MVC): Mô hình MVC phân tách các khía cạnh khác nhau của ứng dụng (logic đầu vào, logic business, và giao diện người dùng logic), và cung cấp một kết nối giữa các yếu tố này.

Model đóng gói dữ liệu ứng dụng và nói chung họ sẽ bao gồm các POJO.

Controller chịu trách nhiệm xử lý yêu cầu người sử dụng và xây dựng Model phù hợp và chuyển nó qua tầng View để hiển thị.

## Code Structure
Cấu trúc chương trình của trang web được tổ chức như sau:
- ./Source: bao gồm class main của chương trình.
- ./Source/Controllers: Chứa các bộ điều khiển (controller) xử lý các yêu cầu (request) và phản hồi (response) với HTTP.
- ./Source/models:  các lớp của các đối tượng có trong chương trình.
- ./Source/images: Chứa các hình nền, hình ảnh sử dụng trong của trang web.
- ./Source/database: Chứa database của trang web.
- ./Source/View: Chứa các dữ liệu mà chúng ta lấy từ dữ liệu trong model để có thể hiển thị đầu ra cho người dùng.

## Các công nghệ sử dụng:
- Jquery
- HTML
- CSS
- JS
- BootStrap
- Jquery Datatable

# Running the Application
## Những công cụ cần có: 
- XAMPP
- Visual Studio Code (hoặc bất cứ các IDE hoặc Code Editer có thể chạy code)
## Import database:
- Mở ứng dụng XAMPP, chọn start Apache và MySQL
- Truy cập phpMyAdmin bằng cách nhấn Admin bên cạnh nút Start MySQL
- Chọn import -> Chọn database dbmovie.sql -> Import
- Mở công cụ lập trình Visual Studio Code
- Open project
- Chạy class main
- Tới trình duyệt và gõ localhost:8080
- Sau khi dùng xong, tắt chương trình ở IDE và Stop Apache, MySQL
## Usage
### Demo account:
- Admin(username/pass): admin/123456
- Demo Voucher: GIAMSOC50PHANTRAM

### Video Demo : <a href="https://www.youtube.com/watch?v=O0tcT08E4J0">Link Video Demo</a>

### Demo Customer:

Ta có hiển thị giao diện trang chủ của user như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/6b9d97047da6c7daf2eb9ab1c3ed2eb4/image.png"/>
Khi muốn đăng nhập thì hệ thống sẽ hiển thị form đăng nhập ta chỉ cần điền Email và password như tài khoản bên trên cung cấp.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/02cb40eb409537d197339c5c17a61a13/image.png"/>
Với account Customer đã cung cấp thì ta đã có thể đăng nhập và được hệ thống chuyển tới giao diện trang chủ. Ở đây, khi muốn đặt vé ta sẽ bấm vào mục lịch chiếu để chọn ngày chiếu và rạp chiếu:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/cce1c2f56b93b6ce59c96f8b4b170d48/image.png"/>
Sau khi chọn rạp chiếu thì các lịch chiếu và phim hiện ra. Ở đây, 5CT chọn phim Khế ước với lịch chiếu là 20:07.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/43163e5fcbe8ab0f34174d3de1b3022b/image.png"/>
Sau khi chọn phim và suất chiếu thì hệ thống cho hiển thị trang chọn ghế với số ghế tương ứng. Ở đây mình sẽ chọn số lượng ghế là 4.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/c3088992684210b105fe695e3a0a9be0/image.png"/>
Sau khi chọn số lượng ghế thì ta bắt đầu chọn vị trí ghế bằng cách tích vào các ghế hiện trên màn hình với số lượng tương ứng là 4 thì mình chọn 4 ghế là A3, A4, A5, A6:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/3b8dd7ead5794ac5c0b1b3eb83f29f39/image.png"/>
Sau khi chọn ghế ta bấm nút chọn combo để hiện thị giao diện tương ứng rồi chọn combo mình thích. Ở đây, chúng ta chọn combo với mức giá là 80000.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/6c8a0f9822da2f21703849dbc9a07271/image.png"/>
Khi bấm thanh toán thì ta được chuyển tới giao diện thanh toán. Ở đây ta áp dụng ưu đãi có mã là WelComeWeb, chọn thanh toán bằng phương thức momo, cuối cùng là tick vào ô đồng ý điều khoản.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/2dd3e5698aa829a01b215cce7272cacf/image.png"/>
Khi bấm nút thanh toán và thanh toán xong thì hệ thống cho hiện giao diện đặt vé thành công và các lưu ý cần thiết.
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/ec87d705784bf3799a78ed0887a6ef8e/image.png"/>

### Demo Admin:

Để đăng nhập vào tài khoản Admin ta dùng Account đã được cung cấp ở trên:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/467a436c7f7b7ffb2d38ea0989e05eaa/image.png"/>
Sau khi đăng nhập thành công hệ thống sẽ cho chuyển giao diện đến trang quản lý, trang quản lý danh sách người dùng là trang hiện lên đầu tiên:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/5d613c0666673fe4ac519b612a9bb31d/image.png"/>
Admin có thể tìm kiếm khách hàng dựa trên ID, ở đây mình sẽ tìm thử với ID là "C80" và kết quả trả ra được:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/736869e57eb8bee9cf4a34420ef7cce3/image.png"/>
Admin có thể sửa thông tin khách hàng trừ Loại và ID, khi bấm nút sửa thì form sửa thông tin khách hàng sẽ hiện lên như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/fe2f2cfb4a7a17ef93ad5827549def89/image.png"/>
Admin có thể quản lý phim, khi chọn mục quản lý phim thì giao diện sẽ được hiện lên như dưới đây:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/441ce6729c78874ee0c30cfdfe377ba4/image.png"/>
Admin có thể tìm kiếm phim dựa trên ID hoặc ngôn ngữ, thể loại, studio. 5CT cho lọc theo thể loại "Hành động" thì nhận được kết quả như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/ebe2b42a26a7f3006fdba2917c0af83d/image.png"/>
Tương tự, khi tìm kiếm theo ID = "M11" thì sẽ được kết quả:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/b7a0be1556349e09292e45b0d3a80dad/image.png"/>
Có thể dùng các cách tìm kiếm chồng lên nhau để lọc kĩ hơn, nếu không có phim nào đạt yêu cầu thì sẽ không hiện phim nào, như dưới đây mình cho lọc theo thể loại "Hành động" và Studio là "Habadicap" thì kết quả trả về là rỗng:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/d4ba88c1624dcdb0bc679d69310b198d/image.png"/>
Admin có thể sửa thông tin phim bằng cách chỉnh sửa form thông tin như bên dưới trừ thông tin về ID:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/c26caba94463f43e1fd299c9b3b214c5/image.png"/>
Khi quản lý lịch sử giao dịch thì giao diện sẽ hiện lên với danh sách lịch sử giao dịch như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/8fadd11b10ecd2e50890deb93dc6ca48/image.png"/>
Ở đây, Admin có thể tìm giao dịch dựa trên ID, 5CT tìm kiếm theo ID = "107" thì nhận được kết quả dưới đây:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/8fadd11b10ecd2e50890deb93dc6ca48/image.png"/>
Admin có thể sửa trạng thái giao dịch bằng cách chỉnh sửa form thông tin như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/254785268975742445f4737187bd434d/image.png"/>
Sau khi sửa và bấm bút sửa giao dịch, khi chỉnh sửa trạng thái từ 0 thành 1 và thành công thì mình nhận được dòng chứ thông báo "Sửa thành công" như sau:  
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/f4b9d58432ce937393f2237e18024a9c/image.png"/>
Quản lý danh sách lịch chiếu của Admin có giao diện như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/2932ad1090a7051230e20e24ad6164e5/image.png"/>
Ta có thể lọc lịch chiếu theo, ID, Movie, Phòng chiếu và định dạng, 5CT lọc theo ID="SH227" và movie="M23-TROLL3" thì nhận được kết quả như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/93a3c77d500018edd4aff7cae4a7942c/image.png"/>
Ta có thể chỉnh sửa lịch chiếu theo form như dưới đây:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/35edfe15ac8ad06028b46ff4ce5217cd/image.png"/>
Giao diện quản lý danh sách Combo của Admin có dạng như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/d99388b5abe45687ffa53dd67d649e60/image.png"/>
Ở đây ta có thể lọc Combo theo mã combo, 5CT lọc theo Mã Combo là "IT9" thì nhận được kết quả như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/36896b91c22e6a7955d310482ed1cbd4/image.png"/>
Admin có giao diện quản lý thống kê như sau:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/2f81aaf5d21444daf8b0e1ece6c69db7/image.png"/>
Ta có thể xem thống kê theo quý:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/9c02c3c07edcd95840ace83681050601/image.png"/>
Và thống kê theo năm:
<img src="https://gitlab.duthu.net/S52100778/do-an-cuoi-ky-mon-lap-trinh-web/uploads/358b5951e83b29e82a3f509ed815e87f/image.png"/>

