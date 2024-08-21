## Table

    1. cust
    	c_id	รหัสลูกค้า
    	c_name	ชื่อลูกค้า
    	c_add	ที่อยู่ลูกค้า
    	c_tel	โทรศัพท์ลูกค้า
    	c_abb	ชื่อย่อลูกค้า

    2. c_depart
     	dp_id	รหัสแผนก
    	c_id	รหัสลูกค้า
    	dp_name	ชื่อแผนก
    3. js_user
    	u_id	รหัสผู้เข้าใช้ระบบ
    	u_user	username
    	u_name	ชื่อผู้เข้าใช้ระบบ
    	u_pass	รหัสผ่าน
    	u_status สถานะผู้ใช้
    4. market
     	mk_id 	รหัสตลาด
    	mk_name ชื่อตลาด
    5. orders
    	od_id	รหัสออเดอร์
    	c_id	รหัสลูกค้า
    	dp_id	รหัสแผนก
    	od_day	วันที่สั่ง
    	dv_day	วันที่ส่ง
    	dv_time	เวลาจัดส่ง

    6. orders_detail
    	odr_id	รหัส รลอ
    	od_id	รัหัสออเดอร์
    	pd_id	รหัสสินค้า
    	ord_quantity	ปริมาณ
    	pu_id	รหัสหน่วยนับ
    	price_s	ราคาขาย
    	total	ผลรวม
    7. pri_detail
    	pri_id	รหัสราคา
    	c_id	รหัสลูกค้า
    	pd_id	รหัสสินค้า
    	pu_id	รหัสหน่วยนับ
    	price_s	ราคาขาย
    8. product
    	pd_id	รหัสสินค้า
    	pd_name	ชื่อสินค้า
    	pt_id	รหัสประเภท
    	pu_id	รหัสหน่วยนับ
    9. prod_stock
    	stock_id รหัสคงคลัง
    	pd_id	 รหัสสินค้า
    	stock_q	 ปริมานสินค้า
    	stock_f	 รายละเอียดสินค้า
    	stock_i	 รูปสินค้า
    	dateCratr เวลาเพิ่มรายการสินค้า

    10. p_type
    	pt_id	รหัสประเภท
    	pt_name	ชื่อประเภท
    11. p_unit
    	pu_id	รหัสหน่วยนับ
    	pu_name	ชื่อหน่วยนับ
    12. mk_sup
    	sp_id	รหัสร้านค้า
    	mk_id	รหัสตลาด
    	sp_name	ชื่อร้านค้า
    	sp_tel	เบอร์โทรศัพท์