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

    TextInputEditText txtnmStudent,txtusnStudent,txtpnoStudent,txtemailStudent,txtpwdStudent,txtcnfpwdStudent,txtAadharId,txtAgeStudent,txtPercentStudent;
    TextInputEditText signinnameTeacher,signinUniqueIdTeacher,signinpnoTeacher,signinemailTeacher,signinpwdTeacher,signinpwdcnfrmTeacher;
    TextInputEditText signinnameAdmin ,signinUniqueIdAdmin,signinpnoAdmin,signinemailAdmin,signinpwdAdmin,signinpwdcnfrmAdmin;

    MemberAdmin memberAdmin;
    MemberStudent memberStudent;
    MemberTeacher memberTeacher;
    Button btnRegisterTeacher;
    Button btnRegisterStudent;
    Button btnRegisterAdmin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        mAuth = FirebaseAuth.getInstance();
        loadingBar = new ProgressDialog(this);
        btnRegisterStudent = findViewById(R.id.submitButtonStudent);
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
                txtPercentStudent = findViewById(R.id.signinPercentStudent);
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
                        final String percent = txtPercentStudent.getText().toString();
                        //todo : get marksheet uri
//                        final String marksheetUri = txt

                        if (!name.isEmpty() && !usn.isEmpty() && !pno.isEmpty() &&
                                !email.isEmpty() && !pwd.isEmpty() && !cnfpwd.isEmpty() && pwd.equals(cnfpwd)) {
                            if (cnfpwd.equals(pwd)) {
                                loadingBar.setTitle("Creating new Account");
                                loadingBar.setMessage("Please wait, while we are creating new account for you...");
                                loadingBar.setCanceledOnTouchOutside(true);
                                loadingBar.show();
                                memberStudent = new MemberStudent();
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
                                                    memberStudent.setStudent_percentage(percent);
                                                    memberStudent.setMarksheetUrl("http//fetch.me");
                                                    long time = System.currentTimeMillis();

                                                    dbref.collection("Students").document(mAuth.getUid())
                                                            .set(memberStudent)
                                                            .addOnCompleteListener(new OnCompleteListener<Void>() {
                                                                @Override
                                                                public void onComplete(@NonNull Task<Void> task) {
                                                                    Toast.makeText(SignUp.this, "Data Added", Toast.LENGTH_SHORT).show();
                                                                    Toast.makeText(SignUp.this, "Data Inserted Successfully!!!", Toast.LENGTH_SHORT).show();
                                                                    startActivity(new Intent(getApplicationContext(), StudentActivity.class));
                                                                }
                                                            });

                                                    loadingBar.dismiss();

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
            case 2: //Teacher Sign UP

                signinnameTeacher            = findViewById(R.id.signinnameTeacher);
                signinUniqueIdTeacher           = findViewById(R.id.signinUniqueIdTeacher);
                signinpnoTeacher           = findViewById(R.id.signinpnoTeacher);
                signinemailTeacher         = findViewById(R.id.signinemailTeacher);
                signinpwdTeacher           = findViewById(R.id.signinpwdTeacher);
                signinpwdcnfrmTeacher        = findViewById(R.id.signinpwdcnfrmTeacher);
                btnRegisterTeacher      = findViewById(R.id.submitButtonTeacher);

                btnRegisterTeacher.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        final String name       = signinnameTeacher.getText().toString();
                        final String usn        = signinUniqueIdTeacher.getText().toString();
                        final String pno        = signinpnoTeacher.getText().toString();
                        final String email      = signinemailTeacher.getText().toString();
                        final String pwd        = signinpwdTeacher.getText().toString();
                        final String cnfpwd     = signinpwdcnfrmTeacher.getText().toString();
                        //todo : get marksheet uri
//                        final String marksheetUri = txt

                        if(!name.isEmpty() && !usn.isEmpty() && !pno.isEmpty() &&
                                !email.isEmpty() && !pwd.isEmpty() && !cnfpwd.isEmpty() && pwd.equals(cnfpwd)) {
                            if (cnfpwd.equals(pwd)) {
                                loadingBar.setTitle("Creating new Account");
                                loadingBar.setMessage("Please wait, while we are creating new account for you...");
                                loadingBar.setCanceledOnTouchOutside(true);
                                loadingBar.show();
                                memberTeacher = new MemberTeacher();
                                mAuth.createUserWithEmailAndPassword(email, pwd)
                                        .addOnCompleteListener(SignUp.this, new OnCompleteListener<AuthResult>() {
                                            @Override
                                            public void onComplete(@NonNull Task<AuthResult> task) {
                                                if (task.isSuccessful()) {
                                                    memberTeacher.setTeacher_name(name);
                                                    memberTeacher.setTeacher_id(usn);
                                                    memberTeacher.setTeacher_phone(pno);
                                                    memberTeacher.setTeacher_email(email);
                                                    memberTeacher.setUser_type("LoginTeacher");// login type is student
                                                    //we encrypt and store password
                                                    memberTeacher.setTeacher_password(""+pwd);
                                                    memberTeacher.setUser_id(mAuth.getUid());
                                                    long time = System.currentTimeMillis();

                                                    dbref.collection("Teachers")
                                                            .add(memberTeacher)
                                                            .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                                                                @Override
                                                                public void onSuccess(DocumentReference documentReference) {
                                                                    Toast.makeText(SignUp.this, "Data Added", Toast.LENGTH_SHORT).show();
                                                                    Toast.makeText(SignUp.this, "Data Inserted Successfully!!!", Toast.LENGTH_SHORT).show();
                                                                    startActivity(new Intent(getApplicationContext(), LoginActivity.class));
                                                                }
                                                            });

                                                    loadingBar.dismiss();

                                                } else {
                                                    loadingBar.dismiss();
                                                    Toast.makeText(SignUp.this, "Authentication failed.", Toast.LENGTH_SHORT).show();

                                                }

                                            }
                                        });
                            } else {
                                Toast.makeText(SignUp.this, "Password Not Confirmed", Toast.LENGTH_SHORT).show();
                            }
                        }
                        else {
                            Snackbar.make(v, "All fields are required.", Snackbar.LENGTH_LONG).show();
                        }

                    }
                });
                break;
            //todo: Change the value to admin
            case 3: //Admin Sign UP

                signinnameAdmin            = findViewById(R.id.signinnameAdmin);
                signinUniqueIdAdmin           = findViewById(R.id.signinusnAdmin);
                signinpnoAdmin           = findViewById(R.id.signinpnoAdmin);
                signinemailAdmin         = findViewById(R.id.signinemailAdmin);
                signinpwdAdmin           = findViewById(R.id.signinpwdAdmin);
                signinpwdcnfrmAdmin        = findViewById(R.id.signinpwdcnfrmAdmin);
                btnRegisterAdmin      = findViewById(R.id.submitAdmin);

                btnRegisterAdmin.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        final String name       = signinnameAdmin.getText().toString();
                        final String usn        = signinUniqueIdAdmin.getText().toString();
                        final String pno        = signinpnoAdmin.getText().toString();
                        final String email      = signinemailAdmin.getText().toString();
                        final String pwd        = signinpwdAdmin.getText().toString();
                        final String cnfpwd     = signinpwdcnfrmAdmin.getText().toString();
                        //todo : get marksheet uri
//                        final String marksheetUri = txt

                        if(!name.isEmpty() && !usn.isEmpty() && !pno.isEmpty() &&
                                !email.isEmpty() && !pwd.isEmpty() && !cnfpwd.isEmpty() && pwd.equals(cnfpwd)) {
                            if (cnfpwd.equals(pwd)) {
                                loadingBar.setTitle("Creating new Account");
                                loadingBar.setMessage("Please wait, while we are creating new account for you...");
                                loadingBar.setCanceledOnTouchOutside(true);
                                loadingBar.show();
                                memberAdmin = new MemberAdmin();
                                mAuth.createUserWithEmailAndPassword(email, pwd)
                                        .addOnCompleteListener(SignUp.this, new OnCompleteListener<AuthResult>() {
                                            @Override
                                            public void onComplete(@NonNull Task<AuthResult> task) {
                                                if (task.isSuccessful()) {
                                                    memberAdmin.setAdmin_name(name);
                                                    memberAdmin.setAdmin_id(usn);
                                                    memberAdmin.setAdmin_phone(pno);
                                                    memberAdmin.setAdmin_email(email);
                                                    memberAdmin.setUser_type("LoginAdmin");// login type is student
                                                    //we encrypt and store password
                                                    memberAdmin.setAdmin_password(""+pwd);
                                                    memberAdmin.setUser_id(mAuth.getUid());
                                                    long time = System.currentTimeMillis();

                                                    dbref.collection("Admins")
                                                            .add(memberAdmin)
                                                            .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                                                                @Override
                                                                public void onSuccess(DocumentReference documentReference) {
                                                                    Toast.makeText(SignUp.this, "Data Added", Toast.LENGTH_SHORT).show();
                                                                    Toast.makeText(SignUp.this, "Data Inserted Successfully!!!", Toast.LENGTH_SHORT).show();
                                                                    startActivity(new Intent(getApplicationContext(), AdminActivity.class));
                                                                }
                                                            });

                                                    loadingBar.dismiss();

                                                } else {
                                                    loadingBar.dismiss();
                                                    Toast.makeText(SignUp.this, "Authentication failed.", Toast.LENGTH_SHORT).show();

                                                }

                                            }
                                        });
                            } else {
                                Toast.makeText(SignUp.this, "Password Not Confirmed", Toast.LENGTH_SHORT).show();
                            }
                        }
                        else {
                            Snackbar.make(v, "All fields are required.", Snackbar.LENGTH_LONG).show();
                        }

                    }
                });
                break;
        }
    }

}