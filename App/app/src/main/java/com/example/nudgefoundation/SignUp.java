package com.example.nudgefoundation;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.ViewStub;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.snackbar.Snackbar;
import com.google.android.material.textfield.TextInputEditText;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.FirebaseFirestore;

public class SignUp extends AppCompatActivity implements AdapterView.OnItemSelectedListener{
    Spinner spinnerUserType;
    ViewStub stubStudent;
    ViewStub stubTeacher;
    ViewStub stubAdmin;
    ProgressDialog loadingBar;
    private Button submitButton;
    FirebaseAuth mAuth;
    FirebaseFirestore dbref;

    TextInputEditText txtnmStudent,txtusnStudent,txtpnoStudent,txtemailStudent,txtpwdStudent,txtcnfpwdStudent,txtAadharId,txtAgeStudent;
    TextInputEditText signinnameTeacher,signinUniqueIdTeacher,signinpnoTeacher,signinemailTeacher,signinpwdTeacher,signinpwdcnfrmTeacher;

    MemberAdmin memberAdmin;
    MemberStudent memberStudent;
    MemberTeacher memberTeacher;
    Button btnRegisterStudent;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        mAuth = FirebaseAuth.getInstance();
        loadingBar = new ProgressDialog(this);
        dbref = FirebaseFirestore.getInstance();
        spinnerUserType             = findViewById(R.id.spinnerUserType);
        stubStudent                 = (ViewStub) findViewById(R.id.layout_stub_student);
        stubTeacher                 = (ViewStub) findViewById(R.id.layout_stub_teacher);
        stubAdmin                   = (ViewStub) findViewById(R.id.layout_stub_admin);
        ArrayAdapter<CharSequence> arrayAdapter = ArrayAdapter.createFromResource(this,R.array.user_type,android.R.layout.simple_spinner_dropdown_item);
        arrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerUserType.setAdapter(arrayAdapter);
        spinnerUserType.setOnItemSelectedListener(this);
    }
    @Override
    public void onItemSelected(AdapterView<?> parent,View view, int position, long id) {
        String userType             = parent.getItemAtPosition(position).toString();
        if(position == 0) {
            stubStudent.setVisibility(View.GONE);// Safe way to use is VISIBLE and GONE.
            stubTeacher.setVisibility(View.GONE);
            stubAdmin.setVisibility(View.GONE);
            //stubSuperAdmin.setVisibility(View.GONE);
        }
        else if (position == 1) {
            stubStudent.setVisibility(View.GONE);// Safe way to use is VISIBLE and GONE.
            stubTeacher.setVisibility(View.GONE);
            stubAdmin.setVisibility(View.GONE);
//            stubSuperAdmin.setVisibility(View.GONE);
            stubStudent.setLayoutResource(R.layout.student_sign_up_form);
            stubStudent.setVisibility(View.VISIBLE);// Or else call using inflateId after inflate is called once.
            signInType(position);

        }
        else if (position == 2){
            stubStudent.setVisibility(View.GONE);// Safe way to use is VISIBLE and GONE.
            stubTeacher.setVisibility(View.GONE);
            stubAdmin.setVisibility(View.GONE);
            //stubSuperAdmin.setVisibility(View.GONE);
            stubTeacher.setLayoutResource(R.layout.teacher_signup_form);stubTeacher.setVisibility(View.VISIBLE);

            signInType(position);

        }
        else if (position == 3){
            stubStudent.setVisibility(View.GONE);// Safe way to use is VISIBLE and GONE.
            stubTeacher.setVisibility(View.GONE);
            stubAdmin.setVisibility(View.GONE);
            //stubSuperAdmin.setVisibility(View.GONE);
            stubAdmin.setLayoutResource(R.layout.admin_signup_form);stubAdmin.setVisibility(View.VISIBLE);
            submitButton =  stubAdmin.findViewById(R.id.submitAdmin);
            signInType(position);
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }
    void signInType(int position) {
        switch (position) {
            case 1:// Student
                txtnmStudent = findViewById(R.id.signinnameStudent);
                txtusnStudent = findViewById(R.id.signinusnStudent);
                txtpnoStudent = findViewById(R.id.signinpnoStudent);
                txtemailStudent = findViewById(R.id.signinEmail);
                txtpwdStudent = findViewById(R.id.signinpwdStudent);
                txtcnfpwdStudent = findViewById(R.id.signinpwdcnfrmStudent);
                btnRegisterStudent = findViewById(R.id.submitButtonStudent);
                txtAadharId = findViewById(R.id.signinAadhar);
                txtAgeStudent = findViewById(R.id.signinage);

                btnRegisterStudent.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        final String name = txtnmStudent.getText().toString();
                        final String usn = txtusnStudent.getText().toString();
                        final String pno = txtpnoStudent.getText().toString();
                        final String email = txtemailStudent.getText().toString();
                        final String aadhar = txtAadharId.getText().toString();
                        final String pwd = txtpwdStudent.getText().toString();
                        final String cnfpwd = txtcnfpwdStudent.getText().toString();
                        final String age = txtAgeStudent.getText().toString();
                        //todo : get marksheet uri
//                        final String marksheetUri = txt

                        if (!name.isEmpty() && !usn.isEmpty() && !pno.isEmpty() &&
                                !email.isEmpty() && !pwd.isEmpty() && !cnfpwd.isEmpty() && pwd.equals(cnfpwd)) {
                            if (cnfpwd.equals(pwd)) {
                                loadingBar.setTitle("Creating new Account");
                                loadingBar.setMessage("Please wait, while we are creating new account for you...");
                                loadingBar.setCanceledOnTouchOutside(true);
                                loadingBar.show();
                                mAuth.createUserWithEmailAndPassword(email, pwd)
                                        .addOnCompleteListener(SignUp.this, new OnCompleteListener<AuthResult>() {
                                            @Override
                                            public void onComplete(@NonNull Task<AuthResult> task) {
                                                if (task.isSuccessful()) {
                                                    memberStudent.setStudent_name(name);
                                                    memberStudent.setStudent_id(usn);
                                                    memberStudent.setStudent_phone(pno);
                                                    memberStudent.setStudent_email(email);
                                                    memberStudent.setStudent_aadhar_number(aadhar);
                                                    memberStudent.setUser_type("LoginStudent");// login type is student
                                                    //we encrypt and store password
                                                    memberStudent.setStudent_password("" + pwd);
                                                    memberStudent.setStudent_age(age);
                                                    memberStudent.setUser_id(mAuth.getUid());
                                                    memberStudent.setMarksheetUrl("http//fetch.me");
                                                    long time = System.currentTimeMillis();

                                                    dbref.collection("Student")
                                                            .add(memberStudent)
                                                            .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                                                                @Override
                                                                public void onSuccess(DocumentReference documentReference) {
                                                                    Toast.makeText(SignUp.this, "Data Added", Toast.LENGTH_SHORT).show();

                                                                }
                                                            });

                                                    loadingBar.dismiss();
                                                    Toast.makeText(SignUp.this, "Data Inserted Successfully!!!", Toast.LENGTH_SHORT).show();
                                                    startActivity(new Intent(getApplicationContext(), LoginActivity.class));
                                                } else {
                                                    loadingBar.dismiss();
                                                    Toast.makeText(SignUp.this, "Authentication failed.", Toast.LENGTH_SHORT).show();

                                                }

                                            }
                                        });
                            } else {
                                Toast.makeText(SignUp.this, "Password Not Confirmed", Toast.LENGTH_SHORT).show();
                            }
                        } else {
                            Snackbar.make(v, "All fields are required.", Snackbar.LENGTH_LONG).show();
                        }

                    }
                });
                break;
            //todo: Change the value to admin
//            case 2: //Teacher Sign UP
//
//                txtnmStudent            = findViewById(R.id.signinnameStudent);
//                txtusnStudent           = findViewById(R.id.signinusnStudent);
//                txtpnoStudent           = findViewById(R.id.signinpnoStudent);
//                txtemailStudent         = findViewById(R.id.signinEmail);
//                txtpwdStudent           = findViewById(R.id.signinpwdStudent);
//                txtcnfpwdStudent        = findViewById(R.id.signinpwdcnfrmStudent);
//                btnRegisterStudent      = findViewById(R.id.submitButtonStudent);
//                txtAadharId = findViewById(R.id.signinAadhar);
//                txtAgeStudent = findViewById(R.id.signinage);
//
//                btnRegisterStudent.setOnClickListener(new View.OnClickListener() {
//                    @Override
//                    public void onClick(View v) {
//                        final String name       = txtnmStudent.getText().toString();
//                        final String usn        = txtusnStudent.getText().toString();
//                        final String pno        = txtpnoStudent.getText().toString();
//                        final String email      = txtemailStudent.getText().toString();
//                        final String aadhar     =  txtAadharId.getText().toString();
//                        final String pwd        = txtpwdStudent.getText().toString();
//                        final String cnfpwd     = txtcnfpwdStudent.getText().toString();
//                        final String age = txtAgeStudent.getText().toString();
//                        //todo : get marksheet uri
////                        final String marksheetUri = txt
//
//                        if(!name.isEmpty() && !usn.isEmpty() && !pno.isEmpty() &&
//                                !email.isEmpty() && !pwd.isEmpty() && !cnfpwd.isEmpty() && pwd.equals(cnfpwd)) {
//                            if (cnfpwd.equals(pwd)) {
//                                loadingBar.setTitle("Creating new Account");
//                                loadingBar.setMessage("Please wait, while we are creating new account for you...");
//                                loadingBar.setCanceledOnTouchOutside(true);
//                                loadingBar.show();
//                                mAuth.createUserWithEmailAndPassword(email, pwd)
//                                        .addOnCompleteListener(SignUp.this, new OnCompleteListener<AuthResult>() {
//                                            @Override
//                                            public void onComplete(@NonNull Task<AuthResult> task) {
//                                                if (task.isSuccessful()) {
//                                                    memberStudent.setStudent_name(name);
//                                                    memberStudent.setStudent_id(usn);
//                                                    memberStudent.setStudent_phone(pno);
//                                                    memberStudent.setStudent_email(email);
//                                                    memberStudent.setStudent_aadhar_number(aadhar);
//                                                    memberStudent.setUser_type("LoginStudent");// login type is student
//                                                    //we encrypt and store password
//                                                    memberStudent.setStudent_password(""+pwd);
//                                                    memberStudent.setStudent_age(age);
//                                                    memberStudent.setUser_id(mAuth.getUid());
//                                                    memberStudent.setMarksheetUrl("http//fetch.me");
//                                                    long time = System.currentTimeMillis();
//
//                                                    dbref.collection("Student")
//                                                            .add(memberStudent)
//                                                            .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
//                                                                @Override
//                                                                public void onSuccess(DocumentReference documentReference) {
//                                                                    Toast.makeText(SignUp.this, "Data Added", Toast.LENGTH_SHORT).show();
//
//                                                                }
//                                                            });
//
//                                                    loadingBar.dismiss();
//                                                    Toast.makeText(SignUp.this, "Data Inserted Successfully!!!", Toast.LENGTH_SHORT).show();
//                                                    startActivity(new Intent(getApplicationContext(), LoginActivity.class));
//                                                } else {
//                                                    loadingBar.dismiss();
//                                                    Toast.makeText(SignUp.this, "Authentication failed.", Toast.LENGTH_SHORT).show();
//
//                                                }
//
//                                            }
//                                        });
//                            } else {
//                                Toast.makeText(SignUp.this, "Password Not Confirmed", Toast.LENGTH_SHORT).show();
//                            }
//                        }
//                        else {
//                            Snackbar.make(v, "All fields are required.", Snackbar.LENGTH_LONG).show();
//                        }
//
//                    }
//                });
//                break;
        }
    }

}