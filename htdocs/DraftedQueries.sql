#Show most popular user that their task was bidded for the most time that category within that week/month

SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid AND t.username = b.taskowner
AND t.type = 'Home'
GROUP BY t.taskid
HAVING COUNT (*) >= ALL (SELECT COUNT (*) FROM bid b2, task t2 WHERE t.taskid = b.taskid AND t.username = b.taskowner AND t.type = 'Home' GROUP BY t2.taskid);


SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid AND t.username = b.taskowner
AND t.type = 'Home'
GROUP BY t.taskid, t.username
HAVING COUNT (*) >= ALL (SELECT COUNT (*) FROM bid b2, task t2 WHERE t2.taskid = b2.taskid AND t2.username = b2.taskowner AND t2.type = 'Home' GROUP BY t2.taskid);


SELECT t.username FROM bid b, task t
WHERE t.taskid = b.taskid AND t.username = b.taskowner
AND t.type = 'Miscellanous '
GROUP BY t.taskid, t.username
HAVING COUNT (*) >= ALL 
(SELECT COUNT (*) FROM bid b2, task t2 
 WHERE t2.taskid = b2.taskid 
 AND t2.username = b2.taskowner 
 AND t2.type = 'Miscellanous ' GROUP BY t2.taskid);


 #User that did not bid for the current month


#user that bid for all my task

#user that constantly bid 0 (for more than 15 tasks)

#lower baller

trigger for add bid

sub routine for add task add etc


