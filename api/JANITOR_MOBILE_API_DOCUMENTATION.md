# THC-FM Janitor Mobile Application API Documentation
**Version**: 1.3 (In Development)  
**Target Developers**: React Native / Flutter / iOS / Android Mobile Developers  
**Base URL**:  
- **Production**: `https://portal.thcfm.com/api/controller/janitor_react.php`  
- **Alternative / Legacy Alias**: `https://portal.thcfm.com/api/controller/janitor.php`  
- **Local Dev**: `http://localhost:3030/api/controller/janitor_react.php`

---

## 1. Overview & General Specifications

* **Content-Type**: `application/json` (or `multipart/form-data` for file uploads, or `x-www-form-urlencoded`).
* **HTTP Methods**: `POST` (recommended for all calls) or `GET`.
* **CORS**: Fully enabled (`Access-Control-Allow-Origin: *`).
* **Payload Support**: JSON body (`php://input`), form-data body, and URL query strings are all supported interchangeably.

---

## 2. Authentication & API Key

All requests **must** include the parameter `APIKEY`.

* **Internal Secret**: `thcauthentication`
* **Encryption**: AES-256-CBC, IV prepended (16 bytes), base64url encoded.
* **Ready-to-use APIKEY Token**:
  ```text
  zdppIbCmWFM0hyEyou_z1Dlp0KzFOs6apWHml9cWHZdAJuz8QPaukrLmlJcMjUEJ
  ```

### Standard Error Codes
| Error Code | HTTP Status | Message | Meaning |
| :--- | :--- | :--- | :--- |
| `101` | 200 | `WRONG API KEY` | Invalid, missing, or corrupt `APIKEY` token |
| `102` | 200 | `EMPLOYEE NOT FOUND` | Janitor code / ID is missing or invalid |
| `105` | 200 | `ASSIGNMENT ID IS REQUIRED` | Missing `assignment_id` |
| `106` | 200 | `CHECKLIST ID REQUIRED` | Missing `checklist_id` |
| `107` | 200 | `SLOT REQUIRED` | Missing time slot |
| `108` | 200 | `EXECUTION ID REQUIRED` | Missing `execution_id` |
| `109` | 200 | `ASSET CODE REQUIRED` | Scanned asset code missing |
| `110` | 200 | `ACTION VALUE REQUIRED or NOT FOUND` | Action event unrecognized |
| `200` | 200 | `NO DATA FOUND` | No schedules or records found |
| `201` | 200 | `INVALID ASSET` | Scanned asset does not exist in system |
| `400` | 200 | `DEVICE LOCATION REQUIRED` | GPS latitude/longitude missing |
| `403` | 200 | `LOCATION MISMATCH` | Janitor is out of premises; **Auto-logout triggered** |

---

## 3. Endpoints Reference

---

### Endpoint 1: Janitor Login & Profile
Retrieves the janitor's active profile details.

* **Action**: `janitor_login` or `get_janitor_profile`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `janitor_login` |
| `emp_code` | String | Yes | Janitor employee code (e.g. `CG-THC-0290`) |

#### Sample Response
```json
{
  "status": "Success",
  "data": {
    "employee_id": "290",
    "employee_code": "CG-THC-0290",
    "employee_name": "Janitor 1",
    "employee_contact_no": "12345678",
    "employee_email_id": "janitor1@thcfm.com",
    "employee_type_name": "Janitor",
    "employee_status": "Active",
    "employee_image": "https://portal.thcfm.com/httpdocs/images/employee_images/default.jpg"
  }
}
```

---

### Endpoint 2: Monthly Calendar Date Highlighting
Returns all dates having scheduled cleaning tasks, with status color badges and a ready-to-use `marked_dates` dictionary for calendar plugins (e.g. `react-native-calendars`).

* **Action**: `get_schedule_dates` or `get_calendar_dates`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_schedule_dates` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `month` | String | No | Month filter: `YYYY-MM` (e.g. `2026-10`) or `1-12` |
| `year` | String | No | Year filter (e.g. `2026`) |
| `from_date`| String | No | Custom range start: `YYYY-MM-DD` |
| `to_date` | String | No | Custom range end: `YYYY-MM-DD` |

#### Status & Color Palette
* **`#4CAF50` (Green)**: `Completed` — All tasks & slots done for that day.
* **`#FF9800` (Orange)**: `Partially Completed` — Tasks in progress.
* **`#39C0ED` (Sky Blue)**: `Scheduled` — Today / upcoming tasks pending execution.
* **`#F44336` (Red)**: `Pending` — Overdue / past unfinished tasks.

#### Sample Response
```json
{
  "status": "Success",
  "from_date": "2026-10-01",
  "to_date": "2026-10-31",
  "total_scheduled_dates": 2,
  "data": [
    {
      "visit_date": "2026-10-13",
      "date": "2026-10-13",
      "status": "Completed",
      "status_color": "#4CAF50",
      "total_tasks": 1,
      "total_slots": 3,
      "completed_slots": 3,
      "pending_slots": 0,
      "is_fully_completed": "Yes"
    },
    {
      "visit_date": "2026-10-14",
      "date": "2026-10-14",
      "status": "Scheduled",
      "status_color": "#39C0ED",
      "total_tasks": 1,
      "total_slots": 3,
      "completed_slots": 0,
      "pending_slots": 3,
      "is_fully_completed": "No"
    }
  ],
  "marked_dates": {
    "2026-10-13": {
      "marked": true,
      "dotColor": "#4CAF50",
      "activeColor": "#4CAF50",
      "selectedColor": "#4CAF50",
      "status": "Completed"
    },
    "2026-10-14": {
      "marked": true,
      "dotColor": "#39C0ED",
      "activeColor": "#39C0ED",
      "selectedColor": "#39C0ED",
      "status": "Scheduled"
    }
  }
}
```

---

### Endpoint 3: Clicked Date Task Listing
Lists all work orders scheduled for a specific clicked date, with asset details, building/location names, and slot statuses.

* **Action**: `get_schedules_by_date` or `get_janitor_assignments`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_schedules_by_date` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `date` | String | Yes | Target date: `YYYY-MM-DD` (e.g. `2026-10-13`) |

#### Sample Response
```json
{
  "status": "Success",
  "date": "2026-10-13",
  "total_schedules": 1,
  "data": [
    {
      "assignment_id": "1",
      "assignment_ref_no": "THC-JN-WO-0001",
      "checklist_id": "1",
      "checklist_name": "TOILET CLEANING CHECKLIST",
      "total_categories": "3",
      "total_points": "11",
      "customer_id": "145",
      "customer_name": "Test Customer",
      "customer_code": "C0145",
      "location_id": "99",
      "location_name": "Seef Location",
      "location_code": "TE",
      "building_id": "329",
      "building_name": "Tower A",
      "building_code": "F0329",
      "building_address": "Road 24, Block 328",
      "latitude": "26.186900",
      "longitude": "50.521030",
      "building_latitude": "26.186900",
      "building_longitude": "50.521030",
      "contact_person_name": "John Doe",
      "contact_person_no": "12345678",
      "asset_id": "75",
      "asset_ref_no": "THC-C0145-TE-F0329-5UD",
      "asset_description": "2nd Floor Ladies Restroom",
      "asset_category_name": "Sanitary",
      "asset_type_name": "Restroom",
      "asset_sp_des": "Ladies Washroom",
      "zone_floor": "2nd Floor",
      "flat_area_code": "East Wing",
      "room_no": "W-204",
      "asset_status": "Active",
      "asset_attachment": "https://portal.thcfm.com/httpdocs/images/amc_attachements/default.jpg",
      "amc_ref_no": "AMC0197",
      "frequency": "Daily",
      "slots": "Morning, Afternoon",
      "start_date": "2026-10-01",
      "end_date": "2026-10-31",
      "work_status": "Partially Completed",
      "work_status_color": "#FF9800",
      "total_slots": 2,
      "completed_slots": 1,
      "pending_slots": 1,
      "is_fully_completed": "No",
      "slots_list": [
        {
          "slot_name": "Morning",
          "slot_time": "Morning",
          "start_time": "08:00",
          "end_time": "10:00",
          "has_time_rule": true,
          "time_rule": "08:00 - 10:00",
          "is_completed": "Yes",
          "execution_id": 14,
          "execution_status": "Completed",
          "remarks": "Cleaned and restocked",
          "executed_at": "2026-10-13 09:45:00"
        },
        {
          "slot_name": "Afternoon",
          "slot_time": "Afternoon",
          "start_time": "0",
          "end_time": "0",
          "has_time_rule": false,
          "time_rule": "No Rule",
          "is_completed": "No",
          "execution_id": null,
          "execution_status": "Pending",
          "remarks": "",
          "executed_at": null
        }
      ],
      "execution_logs": []
    }
  ]
}
```

#### Response Fields Description
| Field | Type | Description |
| :--- | :--- | :--- |
| `building_id` | String / Number | ID of the building where the asset resides |
| `building_name` | String | Building / Facility name |
| `building_address`| String | Physical building address |
| `latitude` / `building_latitude` | String | Building latitude coordinates for geo-fencing & maps |
| `longitude` / `building_longitude` | String | Building longitude coordinates for geo-fencing & maps |
| `slots_list` | Array of Objects | Detailed list of configured service slots for this task |
| `slots_list[].slot_name` | String | Configured name of the slot (e.g. `Morning`, `Afternoon`, `Slot 1`) |
| `slots_list[].start_time` | String | Start time in `HH:mm` format (or `0` if no time window enforced) |
| `slots_list[].end_time` | String | End time in `HH:mm` format (or `0` if no time window enforced) |
| `slots_list[].has_time_rule` | Boolean | `true` if restricted by start/end window; `false` if anytime |
| `slots_list[].time_rule` | String | Readable time rule string (e.g. `08:00 - 10:00` or `No Rule`) |
| `slots_list[].is_completed` | String | `Yes` if slot has been executed; otherwise `No` |
| `slots_list[].execution_id` | Number / null | ID of execution record in `tbl_janitor_execution_log` |
| `slots_list[].execution_status`| String | `Completed` or `Pending` |
| `slots_list[].remarks` | String | Janitor notes recorded upon execution completion |
| `slots_list[].executed_at` | String / null | Timestamp when checklist was executed |

---

### Endpoint 4: QR Scan, Geo-fence Verification & Attendance
When the janitor scans the physical barcode/QR code on the asset in the building, the mobile app sends the scanned code and device GPS coordinates.

* **Action**: `scan_asset_and_verify_location` (or `scan_asset`)
* **Method**: `POST`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `scan_asset_and_verify_location` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `asset_code` | String | Yes | Scanned QR/barcode (e.g. `THC-C0145-TE-F0329-5UD`) |
| `latitude` | Number | Yes | Current device latitude (e.g. `26.186900`) |
| `longitude`| Number | Yes | Current device longitude (e.g. `50.521030`) |
| `allowed_radius_meters` | Number | No | Geo-fence radius limit (Default: `200` meters) |

---

#### Case A: Location Mismatch (Janitor Out of Premises)
The janitor is at a different location (e.g. distance > 200m).
* **Mobile Action**: System triggers **AUTO LOGOUT**. The app must clear session and redirect to the login screen.

```json
{
  "status": "Failed",
  "error_code": "403",
  "rule_status": "FAILED",
  "api_message": "LOCATION MISMATCH: Your location is 10,551.2m away from the assigned building 'Tower A' (allowed limit: 200m). You cannot proceed from a different location and will be logged out.",
  "action_required": "auto_logout",
  "auto_logout": true,
  "can_proceed": false,
  "distance_meters": 10551.21,
  "allowed_radius_meters": 200,
  "building_name": "Tower A",
  "asset_ref_no": "THC-C0145-TE-F0329-5UD",
  "janitor_coordinates": {
    "latitude": 26.25,
    "longitude": 50.6
  },
  "building_coordinates": {
    "latitude": 26.1868798,
    "longitude": 50.521024
  }
}
```

---

#### Case B: Location Matches (Within Premises)
The janitor is within the building radius (<= 200m).
* **System Action**: Marks attendance as **Present** with timestamp, records GPS coordinates in `tbl_janitor_attendance`, and unlocks the cleaning checklist.

```json
{
  "status": "Success",
  "rule_status": "MATCHED",
  "attendance_marked": "Yes",
  "can_proceed": true,
  "auto_logout": false,
  "api_message": "Location verified successfully! Attendance marked as Present. You may now proceed with cleaning.",
  "distance_meters": 2.32,
  "allowed_radius_meters": 200,
  "attendance": {
    "attendance_id": 1,
    "attendance_date": "2026-10-13",
    "attendance_time": "14:52:20",
    "attendance_status": "Present",
    "scan_status": "Verified"
  },
  "asset": {
    "asset_id": 75,
    "asset_ref_no": "THC-C0145-TE-F0329-5UD",
    "asset_description": "2nd Floor Ladies Restroom",
    "asset_category_name": "Sanitary",
    "asset_type_name": "Restroom",
    "zone_floor": "2nd Floor",
    "flat_area_code": "East Wing",
    "room_no": "W-204",
    "building_id": 329,
    "building_name": "Tower A",
    "location_name": "Seef Location"
  },
  "assignment": {
    "assignment_id": 1,
    "checklist_id": 1,
    "checklist_name": "TOILET CLEANING CHECKLIST",
    "slots": "08:00 - 10:00, 14:00 - 16:00",
    "frequency": "Daily"
  }
}
```

---

### Endpoint 5: Checklist Inspection & Cleaning Points
Retrieves the hierarchical categories and item points to inspect and clean.

* **Action**: `get_checklist_items`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_checklist_items` |
| `checklist_id` | Number | Yes* | Checklist ID (or pass `assignment_id`) |
| `assignment_id`| Number | Yes* | Optional if `checklist_id` is supplied |

#### Sample Response
```json
{
  "status": "Success",
  "checklist": {
    "id": "1",
    "checklist_name": "TOILET CLEANING CHECKLIST",
    "status": "Active"
  },
  "data": [
    {
      "category_id": "7",
      "category_name": "Check & Refill",
      "items": [
        { "item_id": "23", "item_description": "Toilet Rolls", "status": "Active" },
        { "item_id": "24", "item_description": "Hand Towels", "status": "Active" },
        { "item_id": "25", "item_description": "Hand Soap", "status": "Active" },
        { "item_id": "26", "item_description": "Hand Sanitizers", "status": "Active" }
      ]
    },
    {
      "category_id": "8",
      "category_name": "Check & Replace",
      "items": [
        { "item_id": "27", "item_description": "Trash Bags", "status": "Active" },
        { "item_id": "28", "item_description": "Air Freshener", "status": "Active" }
      ]
    },
    {
      "category_id": "9",
      "category_name": "Cleanliness",
      "items": [
        { "item_id": "29", "item_description": "Toilet Cubicle & Bowl", "status": "Active" },
        { "item_id": "30", "item_description": "Sink & Fittings", "status": "Active" },
        { "item_id": "31", "item_description": "Floor Swept", "status": "Active" },
        { "item_id": "32", "item_description": "Floor Mopped", "status": "Active" },
        { "item_id": "33", "item_description": "Mirrors Cleaned", "status": "Active" }
      ]
    }
  ]
}
```

---

### Endpoint 6: Upload Proof Photo
Uploads photo proof taken via mobile camera. Supports both multipart binary upload and Base64 string.

* **Action**: `upload_execution_photo`
* **Method**: `POST`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `upload_execution_photo` |
| `photo` | File (Binary) | One of | Multipart binary file from camera/gallery |
| `photo_base64` | String | One of | Base64 encoded image string |

#### Sample Response
```json
{
  "status": "Success",
  "photo_url": "https://portal.thcfm.com/httpdocs/images/janitor_execution/jan_1760367200_4123.jpg",
  "filename": "jan_1760367200_4123.jpg"
}
```

---

### Endpoint 7: Submit Completed Checklist Execution
Submits the completed cleaning record for a slot, including individual points' `Yes`/`No` status, remarks, and photo URLs.

* **Action**: `submit_checklist_execution`
* **Method**: `POST`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `submit_checklist_execution` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `assignment_id`| Number | Yes | Assignment work order ID |
| `slot` | String | Yes | The executed slot time (e.g. `08:00 - 10:00`) |
| `date` | String | No | Date executed (Default: today `YYYY-MM-DD`) |
| `status` | String | No | Execution status: `Completed` (default) |
| `remarks` | String | No | General supervisor / janitor remarks |
| `points` | JSON Array | Yes | Array of checklist point records |

#### Points Payload Structure (`points`)
```json
[
  {
    "checklist_item_id": 23,
    "is_completed": "Yes",
    "remarks": "Restocked 2 rolls",
    "photo_url": "https://portal.thcfm.com/httpdocs/images/janitor_execution/jan_1760367200_4123.jpg"
  },
  {
    "checklist_item_id": 24,
    "is_completed": "Yes",
    "remarks": "Done",
    "photo_url": ""
  },
  {
    "checklist_item_id": 25,
    "is_completed": "No",
    "remarks": "Dispenser empty in supplier stock",
    "photo_url": ""
  }
]
```

#### Sample Response
```json
{
  "status": "Success",
  "api_message": "Execution submitted successfully",
  "execution_id": 14
}
```

---

### Endpoint 8: Job Execution History
Retrieves past execution records submitted by the janitor.

* **Action**: `get_execution_history`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_execution_history` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `from_date`| String | No | Filter start date (`YYYY-MM-DD`) |
| `to_date` | String | No | Filter end date (`YYYY-MM-DD`) |

#### Sample Response
```json
{
  "status": "Success",
  "data": [
    {
      "execution_id": "14",
      "assignment_id": "1",
      "assignment_ref_no": "THC-JN-WO-0001",
      "checklist_name": "TOILET CLEANING CHECKLIST",
      "asset_ref_no": "THC-C0145-TE-F0329-5UD",
      "asset_description": "2nd Floor Ladies Restroom",
      "customer_name": "Test Customer",
      "building_name": "Tower A",
      "location_name": "Seef Location",
      "executed_date": "2026-10-13",
      "executed_slot": "08:00 - 10:00",
      "status": "Completed",
      "remarks": "Cleaned and restocked",
      "created_at": "2026-10-13 09:45:00",
      "total_points": "11",
      "completed_points": "10"
    }
  ]
}
```

---

### Endpoint 9: Past Execution Details by ID
Retrieves detailed breakdown of a past executed job, including all checked points and photos.

* **Action**: `get_execution_details`
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_execution_details` |
| `execution_id` | Number | Yes | The execution ID |

#### Sample Response
```json
{
  "status": "Success",
  "data": {
    "id": "14",
    "assignment_id": "1",
    "assignment_ref_no": "THC-JN-WO-0001",
    "checklist_name": "TOILET CLEANING CHECKLIST",
    "asset_ref_no": "THC-C0145-TE-F0329-5UD",
    "customer_name": "Test Customer",
    "building_name": "Tower A",
    "location_name": "Seef Location",
    "executed_date": "2026-10-13",
    "executed_slot": "08:00 - 10:00",
    "status": "Completed",
    "remarks": "Cleaned and restocked",
    "points": [
      {
        "id": "101",
        "checklist_item_id": "23",
        "item_description": "Toilet Rolls",
        "category_name": "Check & Refill",
        "is_completed": "Yes",
        "remarks": "Restocked",
        "photo_url": "https://portal.thcfm.com/httpdocs/images/janitor_execution/jan_1760367200_4123.jpg"
      }
    ]
  }
}
```

---

### Endpoint 10: Janitor Attendance History
Retrieves past scan and attendance verification records.

* **Action**: `get_janitor_attendance` (or `get_attendance_history`)
* **Method**: `POST` or `GET`

#### Request Parameters
| Parameter | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `APIKEY` | String | Yes | API authentication token |
| `action` | String | Yes | `get_janitor_attendance` |
| `emp_code` | String | Yes | Janitor code (e.g. `CG-THC-0290`) |
| `from_date`| String | No | Filter start date (`YYYY-MM-DD`) |
| `to_date` | String | No | Filter end date (`YYYY-MM-DD`) |

#### Sample Response
```json
{
  "status": "Success",
  "total_records": 2,
  "data": [
    {
      "id": "2",
      "employee_code": "CG-THC-0290",
      "asset_code": "THC-C0145-TE-F0329-5UD",
      "building_name": "Tower A",
      "distance_meters": 2.32,
      "attendance_date": "2026-10-13",
      "attendance_time": "14:52:20",
      "attendance_status": "Present",
      "scan_status": "Verified"
    },
    {
      "id": "1",
      "employee_code": "CG-THC-0290",
      "asset_code": "THC-C0145-TE-F0329-5UD",
      "building_name": "Tower A",
      "distance_meters": 10551.21,
      "attendance_date": "2026-10-13",
      "attendance_time": "14:52:20",
      "attendance_status": "Mismatch",
      "scan_status": "Rejected"
    }
  ]
}
```

---

## 4. Typical Mobile App Lifecycle Flow

```
1. Login Screen
   └─ Call `janitor_login` with emp_code.
   
2. Home / Calendar Screen
   ├─ Call `get_schedule_dates` to highlight calendar with status dots.
   └─ When user taps a date: Call `get_schedules_by_date` to display task cards.

3. Arrived at Premises & Starting Job
   ├─ Janitor clicks "Scan Asset" on task card.
   ├─ Device captures QR code and GPS latitude & longitude.
   ├─ Call `scan_asset_and_verify_location`.
   │    ├─ If `auto_logout: true`: Alert user, log out immediately.
   │    └─ If `attendance_marked: "Yes"`: Show success, open Checklist screen.

4. Cleaning & Inspection Checklist
   ├─ Call `get_checklist_items` to load categories and task points.
   ├─ Janitor ticks items Yes/No, types remarks, and takes photos.
   ├─ When taking photo: Call `upload_execution_photo` -> saves photo_url.

5. Submit Job
   └─ Call `submit_checklist_execution` with the points array.

6. History & Review
   ├─ Call `get_execution_history` to list past completed work orders.
   └─ Call `get_janitor_attendance` to view daily attendance timestamps.
```
