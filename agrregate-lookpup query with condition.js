
//--------------------------------------------------------------------------------------//

const { userInfo } = require("os")

//  ******   HERE IS THE ROW QUERY FOR JOIN & CONDITION FOR TWO DIFFERENT PURPOSE *****//

//----------------------------------------------------------------------------------------//

//REF: https://stackoverflow.com/questions/35813854/how-to-join-multiple-collections-with-lookup-in-mongodb

user  |  userrole | userInfo    |  useradd
------------------------------------------
      |    userId |  userId     |   _id 
      |           | useradd_id  |

          then lookup ma from ma useradd & localfieldma userInfo.useradd_id.

db.users.aggregate([

    // Join with user_info tables
    {
        $lookup:{
            from: "userinfo",       // other table name
            localField: "userId",   // name of users table field
            foreignField: "userId", // name of userinfo table field
            as: "user_info"         // alias for userinfo table
        }
    },
    {   $unwind:"$user_info" },     // $unwind used for getting data in object or for one record only

    // Join with user_role table
    {
        $lookup:{
            from: "userrole", 
            localField: "userId", 
            foreignField: "userId",
            as: "user_role"
        }
    },
    {   $unwind:"$user_role" },

    {
        $lookup:{
            from: "useradd", 
            localField: "userInfo.useradd_id", 
            foreignField: "_id",
            as: "useradd"
        }
    },

    // define some conditions here 
    {
        $match:{
            $and:[{"user_info.userName" : "admin"}]  //condition on join table so total record contorl
        }
    },

    // define which fields are you want to fetch
    {   
        $project:{
            _id : 1,
            email : 1,
            userName : 1,
            userPhone : "$user_info.phone",
            role : "$user_role.role",
        } 
    }
]);


//NOTE FOR PROJECTION: final result mle e pr thi tmare kai field joiye chhe ej field set krvani ena mate Projection use thay
//NOTE FOR UNWIND: unwind means {} ane jo na lakhiye to [{ }] aave.


/**  NOTE: let use for variable (same as use in laravel) define that is used in pipline
 * 
 * pipline is used for condition on join table (not control on the total records)
   */


db.userInfo.aggregate([
    { $lookup:
        {
          from: "address",
          let: { the_city: "$city", the_name: "$name"},
          pipeline: [
               { $match:
                   { $expr:
                       { $and:
                           [
                              { $gt: [ "$city", "$$the_city"] },
                              { $eq: ["$$the_name", "$contact_name" ] }
                           ]
                       }
                   }
               }
           ],
           as: "address"
           }
    }
   ]).pretty();





/** BY DEEP LEVEL POPULATE (populate is always one way) */
/** event has siteuser_id , siteuser has role id so  event->siteuser->role
 * match used of joined table condition
 * whereas main find use for total records controle
 */
eventsModel.find().populate({
    path: 'siteuser_id', //field name
    model: 'site_user',  //model name that you have defined in ref
    match: { wallet_balance: { $gte: 12 }}, //condition on join table
    //select: 'name -_id', //fields select
    //options: { limit: 5 }. //limit
    populate: {
      path: 'role_id', //field name
      model: 'Role', //model name that you have defined in ref
      match: { role:'admin'},
    }
    
  }).then(
    (response) => {
      callback(null, response);
    },
    (error) => {
      callback(error, null);
    }
  );

NOTE: In populate if require join table condition for controling the whole/total num of records then you need to do by loop iterate
 like below code snippet: Here we wants role_id is not null must be role_id is obj of join table

 siteUserModel.find(whereClause).populate({
    path: 'role_id', //field name
    model: 'Role',  //model name that you have defined in ref
    match: { role:'admin'}, //condition on join table
    select: 'role _id', //fields select
    //options: { limit: 5 }. //limit
    
  }).skip(offset).limit(limit).then(
    (data) => {
      if(data){
        console.log("MY DATA:",data[0].role_id);
        for(i=0;i<data.length;i++){
           if(data[i].role_id===null){
            console.log("IN FOR:",i);
            delete data[i];
            
           }
        }
      }
      data = data.filter(function(e){return e}); //remove null,undefined etc
      var response = { data: data, totalrecordsperpage: req.query.size, currentpage: req.query.page, totalpage: number_of_page, totalrecord: number_of_result };
      callback(null, response);
    },
    (error) => {
      callback(error, null);
    }
  );
};




/**
 *  FIND all queires
 * 
 */

  FIND()
---------
Write below queries in find()
REF: https://www.w3resource.com/mongodb/mongodb-all-operators.php


1) $gt $lt $gte $lte
2) $ne
3) $in $nin
4) $or
5) $and
6) $not for not like query
7) $exists  for object have particular key or not if present then that records returns
8) $mod for even/odd number or modular operation
9) $regex for like query
10)$where for javascript expression or function true kre e records return kre
11) MongoDB fetch documents containing 'null'
>db.testtable.find( { "interest" : null } ).pretty();
or use $type

12) (or)AND(or)
find( {
    $and: [
        { $or: [ { qty: { $lt : 10 } }, { qty : { $gt: 50 } } ] },  //or   AND
        { $or: [ { sale: true }, { price : { $lt : 5 } } ] }        //or
    ]
} )

13)(And)or(And)


14) ON ARRAY OBJECT but write in find()

case:1 Array store & search
['ckt','bkt','pkt']              => fieldname  => hobbies

$all use krvu   & $slice use krvu array value limit mate

case 2: object key array


{
    key:['ckt','bkt','pkt']        =>fieldname.keyname =>hobbies.key
}

$all use krvu   &  $slice use krvu array value limit mate

Case 3: array object
[{}]

$elemMatch use krvu


15) skips, limit, sort



/* Other orm queries **/


Model.insertMany([{},{}])
Model.deleteMany()
Model.deleteOne()
Model.find()
Model.findById()
Model.findByIdAndDelete()
Model.findByIdAndRemove()
Model.findByIdAndUpdate()
Model.findOne()
Model.findOneAndDelete()
Model.findOneAndRemove()
Model.findOneAndReplace()
Model.findOneAndUpdate()
Model.replaceOne()
Model.updateMany()
Model.updateOne()



/** GEOSPATIAL */

https://medium.com/@galford151/mongoose-geospatial-queries-with-near-59800b79c0f6

https://docs.mongodb.com/manual/tutorial/geospatial-tutorial/
