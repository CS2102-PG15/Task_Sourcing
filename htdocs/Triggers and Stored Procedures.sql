--Add User Stored Procedure
CREATE FUNCTION add_user(userName VARCHAR(64), email VARCHAR(128), pw VARCHAR(255),  firstName VARCHAR(128), lastName VARCHAR(32), dob DATE, gender VARCHAR(6), isAdmin boolean) 
    RETURNS void AS $$
    BEGIN
      INSERT INTO account VALUES (username,email,pw,firstName,lastName,dob,gender,isAdmin);
    END;
    $$ LANGUAGE plpgsql;

--Dashboard Completed Task Statistic

/** First Draft. DO NOT (NOT NEEDED TO) EXECUTE THIS. Kept for emergency revert purposes. Execute the below query instead **/
CREATE FUNCTION dashboard_completed_task_count(userid VARCHAR(64))
	RETURNS int AS
	$func$
	BEGIN
	   RETURN (
	   	SELECT COUNT(*)::int
	   	FROM task t, bid b
		WHERE t.enddate < date_trunc('day', CURRENT_TIMESTAMP)
        AND t.taskid = b.taskid
        AND t.username = b.taskowner
		AND t.username = userid
		AND b.taskOwner = userid
        AND b.status = 'Accepted'
	   );
	END
	$func$ LANGUAGE plpgsql;

/** Actual **/

CREATE OR REPLACE FUNCTION dashboard_completed_task(userid VARCHAR(64))
	RETURNS TABLE (taskid INT, username VARCHAR(64), title VARCHAR(255), description VARCHAR(512),
                  type VARCHAR(64), price NUMERIC, startdate DATE, starttime TIME, enddate DATE, endtime TIME) AS $$
	BEGIN
	   RETURN Query (
	   	SELECT t.taskid, t.username, t.title, t.description, t.type, t.price, t.startdate, t.starttime, t.enddate, t.endtime
	   	FROM task t, bid b
		WHERE t.enddate < date_trunc('day', CURRENT_TIMESTAMP)
        AND t.taskid = b.taskid
        AND t.username = b.taskowner
		AND t.username = userid
		AND b.taskOwner = userid
        AND b.status = 'Accepted'
	   );
	END
	$$ LANGUAGE plpgsql;

--Create Task Stored Procedure.
CREATE OR REPLACE FUNCTION createTask(userName VARCHAR(64), title VARCHAR(255),	description VARCHAR(512),
	type VARCHAR(64), price NUMERIC, startDate DATE, startTime TIME, endDate DATE, endTime TIME)
	RETURNS void AS $$
	BEGIN
	  INSERT INTO task (userName, title, description, type, startDate, endDate, startTime, endTime, price)
	  VALUES (username, title, description, type, startdate, enddate, starttime, endtime, price);
	END;
	$$ LANGUAGE plpgsql;



--Popular Views
CREATE OR REPLACE VIEW popular_housing_agent AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Housing Agent'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Housing Agent' GROUP BY t2.taskid);

CREATE OR REPLACE VIEW popular_miscellaneous AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Miscellaneous'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Miscellaneous' GROUP BY t2.taskid);

CREATE OR REPLACE VIEW popular_car_washing AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Car Washing'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Car Washing' GROUP BY t2.taskid);

CREATE OR REPLACE VIEW popular_holiday_planner AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Holiday Planer'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Holiday Planer' GROUP BY t2.taskid);


CREATE OR REPLACE VIEW popular_education AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Education'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Education' GROUP BY t2.taskid);


CREATE OR REPLACE VIEW popular_home AS
SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid 
AND t.username = b.taskowner
AND t.type = 'Home'
GROUP BY t.taskid, t.username HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
	WHERE t2.taskid = b2.taskid 
    AND t2.username = b2.taskowner 
    AND t2.type = 'Home' GROUP BY t2.taskid);
