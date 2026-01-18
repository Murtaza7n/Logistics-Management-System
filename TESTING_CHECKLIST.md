# 🧪 LIVE SITE TESTING CHECKLIST

## 📋 Testing Instructions for http://lms.hrmsbs.pk/

### Login Credentials:
- **Username**: admin
- **Password**: admin123

---

## ✅ MENU BUTTONS TO TEST:

### 1. **S2E Logistics** Menu
**Test Items:**
- [ ] Click "S2E Logistics" - dropdown should open
- [ ] Click "Initial Setup" - submenu should open
  - [ ] Item Codes - page loads
  - [ ] Invoice Charges - page loads
  - [ ] SPO / Cargo Officers - page loads
  - [ ] Cargo Office-wise CN Stock Issue - page loads
  - [ ] City Codes - page loads
  - [ ] Zone Codes - page loads
  - [ ] Party or Area-wise Rate - page loads
- [ ] C/N Entry - page loads
- [ ] Vehicle Load Plan - page loads
- [ ] Delivery Sheet - page loads
- [ ] Pickup Sheet - page loads
- [ ] Invoices - page loads
- [ ] Party Fuel Rates for CN - page loads

### 2. **Logistics Reports** Menu
**Test Items:**
- [ ] Click "Logistics Reports" - dropdown should open
- [ ] Click "Sales Reports" - submenu should open
  - [ ] CN Detail - report loads
  - [ ] List of Invoices - report loads
  - [ ] CN Status - report loads
  - [ ] CN Profit / Loss - report loads
  - [ ] City-wise Profit / Loss - report loads
  - [ ] Shipper-wise Profit / Loss - report loads
  - [ ] Hub-wise Profit / Loss - report loads
  - [ ] SPO-wise Profit / Loss - report loads
  - [ ] Hub-wise CN Detail - report loads
  - [ ] Transporter-wise Documents Detail - report loads
  - [ ] Zone-wise Profit / Loss - report loads
- [ ] Click "Edit Lists" - submenu should open
  - [ ] SPO-wise CN Stock Issue List - loads
  - [ ] List of Missing SN Numbers - loads
  - [ ] List of Pending Invoices - loads
  - [ ] List of Item Codes - loads
  - [ ] List of City Codes - loads
  - [ ] City Code Hub-wise List - loads
  - [ ] List of Vehicle Types - loads
  - [ ] List of SPO / Cargo Officers - loads
  - [ ] List of Rates - loads
  - [ ] Party-wise Fuel Rate List - loads
- [ ] Click "Other Reports" - submenu should open
  - [ ] Delivery CN Detail - loads
  - [ ] Group / Party Outstanding with Sales Tax - loads
  - [ ] List of Invoices (Sales Tax Invoice) - loads
  - [ ] CN Detail Account (COD) - loads
  - [ ] Delivery Sheet COD Detail - loads
  - [ ] CN Detail Account COD Status - loads
  - [ ] Stock In Transit - loads
  - [ ] CN In Stock - loads
  - [ ] Non-Service Charges on CN - loads

### 3. **Finance** Menu
**Test Items:**
- [ ] Click "Finance" - dropdown should open
- [ ] Group Codes - page loads
- [ ] Control Codes - page loads
- [ ] Chart of Accounts - page loads
- [ ] Account Grouping - page loads
- [ ] BPV – Bank Payment Voucher - page loads
- [ ] BRV – Bank Receipt Voucher - page loads
- [ ] CPV – Cash Payment Voucher - page loads
- [ ] CRV – Cash Receipt Voucher - page loads
- [ ] JVR – Journal Voucher - page loads
- [ ] Balance Sheet - loads
- [ ] Profit & Loss - loads
- [ ] Change Voucher Date - page loads
- [ ] List of Chart of Accounts - loads
- [ ] List of Vouchers - loads
- [ ] CN-wise Expenses Detail - loads
- [ ] Trial Balance - loads
- [ ] Master Schedule - loads
- [ ] Accounts Ledger - loads
- [ ] Profit & Loss (Comparative) - loads
- [ ] Month-wise Closing Balance Break-up - loads
- [ ] Group Outstanding Detail - loads
- [ ] Group Ledger - loads
- [ ] Trial Balance (Console) - loads
- [ ] Master Schedule (Console) - loads
- [ ] Accounts Ledger (Console) - loads
- [ ] P/L Comparative (Console) - loads
- [ ] Account Grouping Detail - loads
- [ ] Sales Tax Register (Invoice-wise) - loads
- [ ] Sales Tax Register (Customer-wise) - loads
- [ ] Party-wise Outstanding Detailed - loads
- [ ] Party-wise Outstanding (Aging) - loads
- [ ] Party-wise Cleared & Outstanding Detail - loads

### 4. **Finance Reports** Menu
**Test Items:**
- [ ] Click "Finance Reports" - dropdown should open
- [ ] List of Invoices - loads
- [ ] List of Pending Invoices - loads
- [ ] List of Missing C/N Nos. - loads
- [ ] Group/Party Outstanding with S/Tax - loads
- [ ] List of City Codes - loads
- [ ] List of Vehicle Types - loads

### 5. **Purchases** Menu
**Test Items:**
- [ ] Click "Purchases" - dropdown should open
- [ ] Purchases List - page loads
- [ ] Add Purchase - page loads

### 6. **Payroll Section** Menu
**Test Items:**
- [ ] Click "Payroll Section" - dropdown should open
- [ ] Department Codes - page loads
- [ ] Designation Codes - page loads
- [ ] Employee Master File - page loads
- [ ] Loan Master File - page loads
- [ ] Monthly Deduction / Allowances - page loads
- [ ] Authorized Leaves - page loads
- [ ] Monthly Payroll Processing - page loads
- [ ] List of Employees - loads
- [ ] List of Monthly Payroll - loads
- [ ] Deduction / Allowances List - loads
- [ ] Employee Authorized Leaves Detail - loads
- [ ] Employee Leave Status - loads
- [ ] Department-wise Monthly Payroll Register - loads

### 7. **Admin** Menu
**Test Items:**
- [ ] Click "Admin" - dropdown should open
- [ ] Users - page loads
- [ ] Employees - page loads

### 8. **Settings** Menu
**Test Items:**
- [ ] Click "Settings" - dropdown should open
- [ ] Users - page loads
- [ ] User Roles - page loads
- [ ] Change Password - page loads
- [ ] Change Year - page loads
- [ ] Initialize Data for Re-processing - page loads
- [ ] Data Processing - page loads
- [ ] Payroll Processing (FINAL) - page loads
- [ ] System Optimization - page loads
- [ ] Un-Void CN - page loads
- [ ] Email Settings - page loads
- [ ] Inter Branches J.V Code - page loads
- [ ] Un-Post Data with Date Range - page loads

---

## 🔍 ISSUES TO CHECK:

### Dropdown Functionality:
- [ ] All dropdown menus open on click
- [ ] Nested submenus (Initial Setup, Sales Reports, etc.) open correctly
- [ ] Dropdowns close when clicking outside
- [ ] No JavaScript errors in browser console

### Page Loading:
- [ ] All pages load without 500 errors
- [ ] No 404 errors for menu links
- [ ] No permission denied errors
- [ ] Pages display content correctly

### Forms & Actions:
- [ ] Add/Edit forms open correctly
- [ ] Save buttons work
- [ ] Update buttons work
- [ ] Delete buttons work
- [ ] Form validation works

### Reports:
- [ ] Reports load with real data (not empty)
- [ ] Filters work on reports
- [ ] Export functions work (if available)

---

## 📝 ISSUE LOG:

### Issue #1:
- **Menu**: 
- **Button/Link**: 
- **Expected**: 
- **Actual**: 
- **Error Message**: 

### Issue #2:
- **Menu**: 
- **Button/Link**: 
- **Expected**: 
- **Actual**: 
- **Error Message**: 

---

## ✅ FINAL CONFIRMATION:

After testing and fixing:
- [ ] All menu buttons work
- [ ] All dropdowns work
- [ ] All pages load correctly
- [ ] No broken links
- [ ] No JavaScript errors
- [ ] System is stable on live site

---

**Testing Date**: 
**Tester**: 
**Status**: 

