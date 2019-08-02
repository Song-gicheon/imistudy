<!-- 결제 확인 -->
<?php
	include($_SERVER['DOCUMENT_ROOT']."/imistudy/imistudy_2/DBcon.inc.php");

	$sql = "
		DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			DECLARE i INT DEFAULT 1001;
			DECLARE j INT DEFAULT 1;
			DECLARE k INT;
			DECLARE mon INT DEFAULT 0;

			while i<=11000 DO
				SELECT @grade := stat, @race := race_id FROM bus where bus_id = i;
				SELECT @pay := price FROM race where race_id = @race;

				IF(@grade = 1) 
				THEN SET k=45;
				
				ELSEIF(@grade = 2)
				THEN SET k=28;
					 SET @pay= @pay*1.5;
				
				ELSEIF(@grade = 3) 
				THEN SET k=21;
					 SET @pay= @pay*2;
				END IF;

					while j<=k DO		
						INSERT INTO ticket(bus_id, seat_num, user_id, payment) VALUES(i, j, 'test', @pay);
						SET mon = mon + @pay;
						SET j = j+ 1;
					END while;
				SET i = i+1;
				SET j = 1;
			END while;
			UPDATE user SET money = mon WHERE id='test';
		END$$
		DELIMITER ;

		CALL loopInsert;
		";



		DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			DECLARE i INT DEFAULT 441;
			DECLARE j INT DEFAULT 1;
			DECLARE k INT;

			while i<=2502856 DO
				Insert into cancel_tb(bus_id, seat_num, user_id, refund) (SELECT bus_id, seat_num, user_Id, payment*0.1 FROM ticket WHERE ticket_id = i);

				DELETE FROM ticket where ticket_id = i;
				SET i = i+2;
			END while;
		END$$
		DELIMITER ;

		CALL loopInsert;

		DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN

			SELECT @cnt_e := count(*)*45 from bus where race_id=1 and stat=1 and time>= '2019-08-01' and time <'2019-09-01';
			SELECT @cnt_f := count(*)*28 from bus where race_id=1 and stat=2 and time>= '2019-08-01' and time <'2019-09-01';
			SELECT @cnt_p := count(*)*21 from bus where race_id=1 and stat=3 and time>= '2019-08-01' and time <'2019-09-01';
				
		END$$
		DELIMITER ;

		CALL loopInsert;




/*
 1. 시간 단위 예매 매출 통계
  - 시간, 예매 수, 에매 매출, 취소 수, 취소 수수료



 2. 회원 별 하루 단위 예매 매출 통계  
  - 하루 단위, 회원ID, 예매 수, 예매 매출, 취소 수, 취소 수수료



 3. 노선 별 이용률
  - 기간, 노선, 노선에 존재하는 버스 총 좌석 수, 기간 내 예매된 좌석 수



 4. 회원 별 노선 이용률
  - 회원 ID, 노선, 전체 노선 대비 해당 노선 이용률



 전체 노선 대비 해당 노선 이용률 계산

 기간내 버스 이용 승객 수 > 
  select count(*) from ticket join bus on ticket.bus_id = bus.bus_id where and bus.time >= 시작 and bus.time < 끝 ;
   - 만약 회원별로 노선 이용 내역 통계 테이블이 존재한다면.
	  select count(*) from cnt_race where time = 날짜

 기간내 해당 노선 이용 승객 수
 select count(*) from ticket join bus on ticket.bus_id = bus.bus_id where bus.race_id = 노선번호 and bus.time >= 시작 and bus.time < 끝;

 기간내 사용자 별 해당 노선 이용 횟수
 select count(*) from ticket join bus on ticket.bus_id = bus.bus_id where bus.race_id = 노선번호 and ticket.user_id='사용자명' and bus.time >= 시작 and bus.time < 끝;

 * 기간내 해당 노선의 이용 가능한 좌석 수 -> 등급 별 합산
			SELECT @cnt_e := count(*)*45 from bus where race_id=1 and stat=1 and time>= '2019-08-01' and time <'2019-09-01';
			SELECT @cnt_f := count(*)*28 from bus where race_id=1 and stat=2 and time>= '2019-08-01' and time <'2019-09-01';
			SELECT @cnt_p := count(*)*21 from bus where race_id=1 and stat=3 and time>= '2019-08-01' and time <'2019-09-01';
 
 
 예매 및 취소 내역 계산
 
 기간내 사용자 별 예매 횟수 및 사용 금액
  select count(*), sum(payment) from ticket where user_id='사용자명' and ticketing_time >= 시작 and ticketing_time < 끝;
  
 기간내 사용자 별 예매 취소 횟수 및 취소 수수료
  select count(*), sum(refund) from cancel_tb where user_id='사용자명' and cancel_time >= 시작 and cancel_time < 끝;

  
 ex) 2019-08 이용 승객
  기간 내 버스 이용 승객 수			: 188944	 
  기간 내 전주-서울 승객 수			: 11564		 
  기간 내 전주-서울 좌석 수			: 23618		 
  기간 내 전주-서울 여성 승객 수	: 0			 
  기간 내 전주-서울 남성 승객 수	: 11564		
  기간 내 'test' 의 전주-서울 예매	: 11564
  기간 내 'test' 의 예매 횟수		: 188808	 
  기간 내 'test' 의 사용 금액		: 4258926000 
  기간 내 'test' 의 예매 취소 횟수	: 188808	 
  기간 내 'test' 의 취소 수수료		: 425892600 

  -> 기간 내 전체 노선 대비 전주-서울 이용률	: 11564/188944 * 100 = 6.12%
  -> 기간 내 전주-서울 노선 좌석 예매율			: 11564/23618  * 100 = 48.96%
  


	1.  시간대별로 while 반복문 
	2.	select 구문에 사용되는 회원 ID값 조회 필요 
	3.	반복문 내에서 해당 시간대 정보 select

	4.	select 결과값을 각 통계 테이블에 입력

	DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			select @sT := min(ticketing_time) from ticket;
			select @mT := max(cancel_time) from cancel_tb;
			while @sT < @mT DO				
				
				INSERT INTO sales_hour(term, user_id, ticket_cnt, ticket_pay) 
				SELECT @sT, user_id, count(ticket_id), sum(payment) FROM ticket 
				WHERE user_id IN (select id from user) AND ticketing_time >= @sT AND ticketing_time < DATE_ADD(@sT, interval +1 hour)
				GROUP BY user_id;

				SET @sT = DATE_ADD(@sT, interval +1 hour);
			END while;
		END$$
	DELIMITER ;

	CALL loopInsert;




 INSERT INTO sales_hour(term, user_id, ticket_cnt, ticket_pay) 
 SELECT '2019-07-28 13:00:00', user_id, count(ticket_id), sum(payment) FROM ticket WHERE user_id IN (select id from user) and ticketing_time >= '2019-07-29' and ticketing_time < '2019-08-01' group by user_id;



 SELECT count(race_id) 
 FROM(select race_id from bus where bus_id in ( select distinct bus_id from ticket ) A group by race_id;


// 전체 매출 통계값
// SELECT A.pay + B.ref FROM (SELECT sum(payment) AS pay FROM ticket) A, (SELECT sum(refund) AS ref FROM cancel_tb) B;

// 예매 매출

// 취소 수수료 매출

// 기간


 update cancel_tb, bus set cancel_tb.cancel_time = DATE_ADD(bus.time, interval -1 day) where cancel_tb.bus_id = bus.bus_id;

*/
 
 sales_hour 입력

	DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			select @sT := min(ticketing_time) from ticket;
			select @mT := max(cancel_time) from cancel_tb;
			while @sT < @mT DO				
				
				INSERT INTO sales_hour(term, user_id, ticket_cnt, ticket_pay) 
				SELECT @sT, user_id, count(ticket_id), sum(payment) FROM ticket 
				WHERE user_id IN (select id from user) AND ticketing_time >= @sT AND ticketing_time < DATE_ADD(@sT, interval +1 hour)
				GROUP BY user_id;

				SET @sT = DATE_ADD(@sT, interval +1 hour);
			END while;
		END$$
	DELIMITER ;

	CALL loopInsert;


 cancel_hour 입력 해주기


 	DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			select @sT := min(ticketing_time) from ticket;
			select @mT := max(cancel_time) from cancel_tb;
			while @sT < @mT DO				
				
				INSERT INTO cancel_hour(term, user_id, cancel_cnt, cancel_ref) 
				SELECT @sT, user_id, count(cancel_id), sum(refund) FROM cancel_tb 
				WHERE user_id IN (select id from user) AND cancel_time >= @sT AND cancel_time < DATE_ADD(@sT, interval +1 hour)
				GROUP BY user_id;

				SET @sT = DATE_ADD(@sT, interval +1 hour);
			END while;
		END$$
	DELIMITER ;

	CALL loopInsert;


 using_race 입력

  	DELIMITER $$
		DROP PROCEDURE IF EXISTS loopInsert$$

		CREATE PROCEDURE loopInsert()
		BEGIN
			DECLARE k INT DEFAULT 1;
			select @sT := min(ticketing_time) from ticket;
			select @mT := max(cancel_time) from cancel_tb;
			
			while @sT < @mT DO				
				while k <= 16 DO
					INSERT INTO using_race(term, race_id, user_id, use_cnt)
					SELECT @sT, race_id, user_id, count(*)
					FROM ticket JOIN bus ON ticket.bus_id = bus.bus_id 
					WHERE bus.time >= @sT AND bus.time < DATE_ADD(@sT, interval +1 day) AND race_id=k
					group by ticket.user_id;
					
					SET k = k+1;
				END while;

				SET @sT = DATE_ADD(@sT, interval +1 day);
				SET k=1;
			END while;
		END$$
	DELIMITER ;

	CALL loopInsert;