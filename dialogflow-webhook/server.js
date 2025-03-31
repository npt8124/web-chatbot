const express = require("express");
const bodyParser = require("body-parser");

const app = express();
app.use(bodyParser.json());

const fruitPrices = {
    "Táo": 55000,
    "Cam sành": 25000,
    "Chuối cau": 25000,
    "Dưa hấu ruột đỏ": 23000,
    "Dưa lưới ruột vàng": 33000,
    "Mận An Phước": 38000,
    "Kiwi vàng nhập khẩu": 200000,
    "Lựu Ấn Độ": 300000,
    "Nho đen không hạt": 150000,
    "Bưởi ruột đỏ": 55000,
    "Thanh long ruột đỏ": 37000,
    "Dừa xiêm nguyên trái": 25000,
    "Quýt nhập khẩu Úc": 35000,
    "Xoài": 26000
};

// Bộ nhớ tạm thời để lưu đơn hàng của từng người dùng (theo sessionId)
let userOrders = {};

app.post("/webhook", (req, res) => {
    const sessionId = req.body.session; // Lấy session ID của người dùng
    const parameters = req.body.queryResult.parameters;
    let fruit = parameters.fruit;
    let quantity = parameters.quantity;

    // Nếu sessionId chưa có trong bộ nhớ, tạo mới
    if (!userOrders[sessionId]) {
        userOrders[sessionId] = {};
    }

    // Nếu người dùng chỉ nhập số lượng mà chưa nhập trái cây, lấy từ bộ nhớ trước đó
    if (!fruit && userOrders[sessionId].fruit) {
        fruit = userOrders[sessionId].fruit;
    }

    // Nếu người dùng nhập trái cây, lưu vào bộ nhớ
    if (fruit) {
        userOrders[sessionId].fruit = fruit;
    }

    // Nếu số lượng chưa được nhập trước đó, bot sẽ hỏi tiếp
    if (!quantity) {
        return res.json({
            fulfillmentText: `Bạn muốn mua bao nhiêu kg ${fruit}?`
        });
    }

    // Lưu số lượng vào bộ nhớ
    userOrders[sessionId].quantity = quantity;
    
    // Kiểm tra xem loại trái cây có trong danh sách không
    if (fruit && fruitPrices[fruit]) {
        let price = fruitPrices[fruit] * quantity;
        return res.json({
            fulfillmentText: `Bạn muốn mua ${quantity}kg ${fruit}. Tổng giá: ${price.toLocaleString()} VND.`
        });
    } else {
        return res.json({ 
            fulfillmentText: `Xin lỗi, chúng tôi không có thông tin về ${fruit}.` 
        });
    }
});

// Chạy server tại cổng 3000
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Webhook server running on port ${PORT}`);
});
