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

-- update bid status - stored procedure
CREATE OR REPLACE FUNCTION updateBidStatus()
RETURNS TRIGGER AS $bid_table$
BEGIN
   IF NEW.status = 'Accepted' THEN
   UPDATE bid SET status = 'Rejected' WHERE status = 'Pending' AND taskid = NEW.taskid AND taskowner = NEW.taskowner;
   END IF;
   IF NEW.status = 'Pending' THEN
   UPDATE bid SET status = 'Pending' WHERE status = 'Rejected' AND taskid = NEW.taskid AND taskowner = NEW.taskowner;
   END IF;
   RETURN NEW;
END;
$bid_table$ LANGUAGE plpgsql;

--update bid status - trigger
CREATE TRIGGER updateOtherBids 
AFTER UPDATE
ON bid
FOR EACH ROW 
EXECUTE PROCEDURE updateBidStatus();

