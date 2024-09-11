(*) A: Module: src/app/code/Ecentura/FreeProduct
Assumption: Nếu Free Product chưa có trong cart, Free Product Section sẽ được hiển thị và ngược lại. User chỉ được add 1 quantity for Free Product.
Issse: Phần Qty ở cart table cho phép điều chỉnh quantity của Free Product. Ta có thể override phần này, compare SKU / Product Instance của Free Product và Cart Products và disable field này đi.
Result video: https://www.awesomescreenshot.com/video/31365368?key=e66177097c9219268ea249c0f126fa53

(*) B: Module: src/app/code/Ecentura/FileAttachment
https://www.awesomescreenshot.com/image/50491534?key=e14a2a2f18ffba91ca469f300f6e0f1d
Hiện tại ở phần này em đã tạo được configuration fields cho pdf và image file. Em đang stuck trong việc attach cùng invoice email.

(*) C: Module: src/app/code/Ecentura/CustomerProducts
https://www.awesomescreenshot.com/image/50511388?key=313e08cca97888057e5d8b7c34390a58
Hiện tại ở phần này em đã tạo được 1 tab trong customer detail và add được products grid vào trong tab này. Những phần phía sau em sẽ tóm tắt cách xử lý trước và em sẽ process tiếp sau khi giải quyết xong test B.
- Save data to customer attribute: phần này em sẽ tạo 1 customer attribute mới để lưu products ID vào. 