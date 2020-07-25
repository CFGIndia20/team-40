package com.example.nudgefoundation;

public class MemberStudent {
    String student_name;
    String student_id;
    String student_email;
    String student_phone;
    String student_age;
    String student_aadhar_number;
    String marksheetUrl;
    String student_password;
    String user_type;
    String user_id;

    public MemberStudent() {
    }

    public MemberStudent(String student_name, String student_id, String student_email, String student_phone, String student_age, String student_aadhar_number, String marksheetUrl, String student_password, String user_type, String user_id) {
        this.student_name = student_name;
        this.student_id = student_id;
        this.student_email = student_email;
        this.student_phone = student_phone;
        this.student_age = student_age;
        this.student_aadhar_number = student_aadhar_number;
        this.marksheetUrl = marksheetUrl;
        this.student_password = student_password;
        this.user_type = user_type;
        this.user_id = user_id;
    }

    public String getStudent_name() {
        return student_name;
    }

    public void setStudent_name(String student_name) {
        this.student_name = student_name;
    }

    public String getStudent_id() {
        return student_id;
    }

    public void setStudent_id(String student_id) {
        this.student_id = student_id;
    }

    public String getStudent_email() {
        return student_email;
    }

    public void setStudent_email(String student_email) {
        this.student_email = student_email;
    }

    public String getStudent_phone() {
        return student_phone;
    }

    public void setStudent_phone(String student_phone) {
        this.student_phone = student_phone;
    }

    public String getStudent_age() {
        return student_age;
    }

    public void setStudent_age(String student_age) {
        this.student_age = student_age;
    }

    public String getStudent_aadhar_number() {
        return student_aadhar_number;
    }

    public void setStudent_aadhar_number(String student_aadhar_number) {
        this.student_aadhar_number = student_aadhar_number;
    }

    public String getMarksheetUrl() {
        return marksheetUrl;
    }

    public void setMarksheetUrl(String marksheetUrl) {
        this.marksheetUrl = marksheetUrl;
    }

    public String getStudent_password() {
        return student_password;
    }

    public void setStudent_password(String student_password) {
        this.student_password = student_password;
    }

    public String getUser_type() {
        return user_type;
    }

    public void setUser_type(String user_type) {
        this.user_type = user_type;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }
}
