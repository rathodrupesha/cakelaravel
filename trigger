Remember 
NEW for insert or update
OLD for deleted
========================================
DELIMITER //

CREATE TRIGGER addActivity_after_insert
AFTER INSERT
   ON patientsphotos FOR EACH ROW

BEGIN
 
   

    INSERT INTO activities
   ( activity_creator,
     activity_type
    )
   VALUES(NEW.user_id,'3' );

END; //

DELIMITER ;
=================================================
DELIMITER //

CREATE TRIGGER addActivity_after_insert_video
AFTER INSERT
   ON patient_videos FOR EACH ROW

BEGIN
   DECLARE P1,P2 int(11); 
   SELECT user_id INTO P1 FROM doctors WHERE id=NEW.doctor_id;
   SELECT user_id INTO P2 FROM patients WHERE id=NEW.patient_id;

    INSERT INTO activities
   ( activity_creator,
    activity_listner,
     activity_type
    )
   VALUES(P1,P2,'3' );

END; //

DELIMITER ;


===========================================================



BEGIN
 INSERT INTO activities
   ( activity_creator,
     activity_type
    )
   VALUES(user_id,'3' );

END;
