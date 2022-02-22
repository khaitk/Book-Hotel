-- test truy vấn dữ liệu
SELECT rooms.id as id, startDate, endDate 
FROM rooms LEFT OUTER JOIN bookings ON rooms.id = bookings.idRoom 
where idHotel = 2 
ORDER BY rooms.id asc



SELECT rooms.id as id, startDate, endDate 
FROM rooms LEFT OUTER JOIN bookings ON rooms.id = bookings.idRoom, hotels 
where hotels.id = rooms.idHotel 
ORDER BY rooms.id asc

-- tổng đơn từng tháng

SELECT YEAR(papaymentDate), MONTH(papaymentDate), SUM(totalPrice) FROM `bills`
where MONTH(papaymentDate) = MONTH(NOW()) 
AND YEAR(papaymentDate) = YEAR(NOW())
GROUP BY YEAR(papaymentDate), MONTH(papaymentDate)


---Hien thi nguoi dung dat phong va hoa don

select hotels.name as namehotels, rooms.name as namerooms, papaymentDate, totalPrice, papaymentType, startDate, endDate 
from bills, bookings, rooms, hotels, users 
WHERE bills.idBooking = bookings.id 
AND bookings.idRoom = rooms.id 
AND rooms.idHotel = hotels.id 
AND bookings.idUser = users.id


--- hiển thị trong bảng room ----
SELECT hotels.id, rooms.id, review.idRoom, COUNT(review.id), ROUND(SUM(review.rating)/COUNT(review.id), 1) 
FROM rooms INNER JOIN hotels ON rooms.idHotel = hotels.id LEFT JOIN review ON rooms.id = review.idRoom 
GROUP BY hotels.id, rooms.id, review.idRoom