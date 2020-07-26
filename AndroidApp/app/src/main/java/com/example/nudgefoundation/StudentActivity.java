package com.example.nudgefoundation;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;
import com.google.firebase.firestore.SetOptions;

import java.util.ArrayList;

public class StudentActivity extends AppCompatActivity {

    RecyclerView mRecyclerViewCompanyList;
    FirebaseAuth mAuth;
    FirebaseFirestore dbref;
    Button btnApply1;
    Button btnApply2;
    MemberStudent memberStudent;
    int count =0;

    ArrayList<CompanyModel> companyLists = new ArrayList<CompanyModel>();;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student);
        mAuth = FirebaseAuth.getInstance();
        dbref = FirebaseFirestore.getInstance();
        memberStudent= new MemberStudent();
        btnApply1 = findViewById(R.id.btn_apply1);
        btnApply2 = findViewById(R.id.btn_apply2);
        btnApply1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dbref.collection("Students")
                        .get()
                        .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                            @Override
                            public void onComplete(@NonNull Task<QuerySnapshot> task) {
                                if (task.isSuccessful())
                                {
                                    btnApply1.setText("Applied");
                                    btnApply1.setBackgroundResource(R.color.green);
                                }
                                for (QueryDocumentSnapshot document: task.getResult())
                                {
                                    Toast.makeText(StudentActivity.this, ""+(count++), Toast.LENGTH_SHORT).show();
                                    memberStudent = document.toObject(MemberStudent.class);
                                    if (memberStudent.getStudent_id().equals(mAuth.getUid()))
                                    {
                                        dbref.collection("Companies")
                                                .document(/*companyModel.getCompany_ID()*/"KLhEiMjFZeHYk9zQgcBF")
                                                .collection("StudentsApplied")
                                                .document(mAuth.getUid())
                                                .set(memberStudent,SetOptions.merge());

                                    }
                                }
                            }
                        });

            }
        });


        // btn 2 for jpmc
        btnApply2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dbref.collection("Students")
                        .get()
                        .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                            @Override
                            public void onComplete(@NonNull Task<QuerySnapshot> task) {
                                if (task.isSuccessful())
                                {
                                    btnApply2.setText("Applied");
                                    btnApply2.setBackgroundResource(R.color.green);
                                }
                                for (QueryDocumentSnapshot document: task.getResult())
                                {
                                    Toast.makeText(StudentActivity.this, "Student Login", Toast.LENGTH_SHORT).show();
                                    memberStudent = document.toObject(MemberStudent.class);
                                    if (memberStudent.getStudent_id().equals(mAuth.getUid()))
                                    {
                                        dbref.collection("Companies")
                                                .document(/*companyModel.getCompany_ID()*/"\n" +
                                                        "\n" +
                                                        "lD8xk0u6lK6TIa3cHgxD")
                                                .collection("StudentsApplied")
                                                .document(mAuth.getUid())
                                                .set(memberStudent,SetOptions.merge());

                                    }
                                }
                            }
                        });

            }
        });


//        mRecyclerViewCompanyList = findViewById(R.id.recycler_company_list);
//        displayCompanyLists();



    }

    private void displayCompanyLists() {
        Toast.makeText(this, "Inside display", Toast.LENGTH_SHORT).show();
        mRecyclerViewCompanyList.clearOnScrollListeners();
        mRecyclerViewCompanyList.clearOnChildAttachStateChangeListeners();

        dbref.collection("Companies")
                .get()
                .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                    @Override
                    public void onComplete(@NonNull Task<QuerySnapshot> task) {
//                        companyLists.clear();
                        if (task.isSuccessful())
                        {
                            for (QueryDocumentSnapshot document: task.getResult())
                            {
                                companyLists.add(document.toObject(CompanyModel.class));
                                Toast.makeText(StudentActivity.this, document.toObject(CompanyModel.class).company_name.toString(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }
                });
        mRecyclerViewCompanyList.clearOnScrollListeners();
        mRecyclerViewCompanyList.clearOnChildAttachStateChangeListeners();
        Toast.makeText(this, "Reached Recycler", Toast.LENGTH_SHORT).show();
        //This sets the all data from the firebase onto the adapter
        CompaniesAdapter myAdapter= new CompaniesAdapter(companyLists);
        /* todo: rectify error*/
        RecyclerView.LayoutManager recyce=new GridLayoutManager(mRecyclerViewCompanyList.getContext(),1);
        mRecyclerViewCompanyList.setLayoutManager(recyce);
        mRecyclerViewCompanyList.setItemAnimator(new DefaultItemAnimator());
        mRecyclerViewCompanyList.setAdapter(myAdapter);

    }
}