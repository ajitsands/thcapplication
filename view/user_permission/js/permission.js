$(document).ready(function() {
    // Your JavaScript code here
    function hasPermission(permission) {
        return permissions.includes(permission);
    }
    window.hasPermission=hasPermission;

    // Hide controls based on permissions
//     var addActionButtons = document.querySelectorAll(".addAction");
//     var editActionButtons = document.querySelectorAll(".editAction");
//     var deleteActionButtons = document.querySelectorAll(".deleteAction");
//     var listActionButtons = document.querySelectorAll(".listAction");
// 	var saveActionButtons = document.querySelectorAll(".saveAction");
// 	var printActionButtons = document.querySelectorAll(".printAction");
// 	var uploadActionButtons = document.querySelectorAll(".uploadAction");
	var exportToExcelActionButtons = document.querySelectorAll(".exportToExcelAction");
	var exportToPDFActionButtons = document.querySelectorAll(".exportToPDFAction");
	



	var eventCalenderView = document.querySelectorAll(".classCalenderView");

	var eventCalenderModify = document.querySelectorAll(".classCalenderModify");

	var eventExpertiseView = document.querySelectorAll(".classExpertiseView");

	var eventExpertiseModify = document.querySelectorAll(".classExpertiseModify");

	var eventEmployeesView = document.querySelectorAll(".classEmployeesView");

	var eventEmployeesModify = document.querySelectorAll(".classEmployeesModify");

	var eventCPRAndVisaExpiryView = document.querySelectorAll(".classCPRAndVisaExpiryView");

	var eventLocationAndFacilitiesView = document.querySelectorAll(".classLocationAndFacilitiesView");

	var eventLocationAndFacilitiesModify = document.querySelectorAll(".classLocationAndFacilitiesModify");

	var eventContractTypeAndAssetCategoryView = document.querySelectorAll(".classContractTypeAndAssetCategoryView");

	var eventContractTypeAndAssetCategoryModify = document.querySelectorAll(".classContractTypeAndAssetCategoryModify");

	var eventAssetTypeView = document.querySelectorAll(".classAssetTypeView");

	var eventAssetTypeModify = document.querySelectorAll(".classAssetTypeModify");

	var eventServicesView = document.querySelectorAll(".classServicesView");

	var eventServicesModify = document.querySelectorAll(".classServicesModify");

	var eventCustomerView = document.querySelectorAll(".classCustomerView");

	var eventCustomerModify = document.querySelectorAll(".classCustomerModify");

	var eventCustomerFacilityView = document.querySelectorAll(".classCustomerFacilityView");

	var eventCustomerFacilityModify = document.querySelectorAll(".classCustomerFacilityModify");

	var eventCustomerAssetView = document.querySelectorAll(".classCustomerAssetView");

	var eventCustomerAssetModify = document.querySelectorAll(".classCustomerAssetModify");

	var eventCustomerDirectoryView = document.querySelectorAll(".classCustomerDirectoryView");

	var eventCustomerDirectoryModify = document.querySelectorAll(".classCustomerDirectoryModify");

	var eventBookWoView = document.querySelectorAll(".classBookWoView");

	var eventBookWoModify = document.querySelectorAll(".classBookWoModify");

	var eventWoOpenedView = document.querySelectorAll(".classWoOpenedView");

	var eventWoOpenedModify = document.querySelectorAll(".classWoOpenedModify");

	var eventWoScheduledView = document.querySelectorAll(".classWoScheduledView");

	var eventWoScheduledModify = document.querySelectorAll(".classWoScheduledModify");

	var eventWoAssignedView = document.querySelectorAll(".classWoAssignedView");

	var eventWoAssignedModify = document.querySelectorAll(".classWoAssignedModify");

	var eventWoExtensionView = document.querySelectorAll(".classWoExtensionView");

	var eventWoExtensionModify = document.querySelectorAll(".classWoExtensionModify");

	var eventWoCompletedView = document.querySelectorAll(".classWoCompletedView");

	var eventWoCompletedModify = document.querySelectorAll(".classWoCompletedModify");

	var eventWoClosedView = document.querySelectorAll(".classWoClosedView");

	var eventWoClosedModify = document.querySelectorAll(".classWoClosedModify");

	var eventWoCancelledView = document.querySelectorAll(".classWoCancelledView");

	var eventWoEscalatedView = document.querySelectorAll(".classWoEscalatedView");

	var eventWoEscalatedModify = document.querySelectorAll(".classWoEscalatedModify");

	var eventWoReport = document.querySelectorAll(".classWoReport");

	var eventTrackWo = document.querySelectorAll(".classTrackWo");

	var eventDailyTeamReport = document.querySelectorAll(".classDailyTeamReport");

	var eventDailyActivityReport = document.querySelectorAll(".classDailyActivityReport");

	var eventWoExport = document.querySelectorAll(".classWoExport");

	var eventServiceReportExport = document.querySelectorAll(".classServiceReportExport");

	var eventSubContractorsView = document.querySelectorAll(".classSubContractorsView");

	var eventSubContractorsModify = document.querySelectorAll(".classSubContractorsModify");

	var eventBookAMC = document.querySelectorAll(".classBookAMC");

	var eventSearchAMC = document.querySelectorAll(".classSearchAMC");

	var eventScheduleAMC = document.querySelectorAll(".classScheduleAMC");

	var eventAssignServicesAMC = document.querySelectorAll(".classAssignServicesAMC");

	var eventAssignTechniciansAMC = document.querySelectorAll(".classAssignTechniciansAMC");

	var eventAMCReschedule = document.querySelectorAll(".classAMCReschedule");

	var eventCompletedAMCView = document.querySelectorAll(".classCompletedAMCView");

	var eventCompletedAMCModify = document.querySelectorAll(".classCompletedAMCModify");

	var eventClosedAMCView = document.querySelectorAll(".classClosedAMCView");

	var eventClosedAMCModify = document.querySelectorAll(".classClosedAMCModify");

	var eventRenewAMC = document.querySelectorAll(".classRenewAMC");

	var eventMaterialRequisitionView = document.querySelectorAll(".classMaterialRequisitionView");

	var eventMaterialRequisitionModify = document.querySelectorAll(".classMaterialRequisitionModify");

	var eventLogsView = document.querySelectorAll(".classLogsView");

	var eventDashboard = document.querySelectorAll(".classDashboard");


	var eventCustomerFeedbackReportView = document.querySelectorAll(".classCustomerFeedbackReportView");

	var eventGivePermission = document.querySelectorAll(".classGivePermission");

	var eventExportToPDF = document.querySelectorAll(".classExportToPDF");

	var eventAssetsAndServiceModule = document.querySelectorAll(".classAssetsAndServiceModule");

	var eventCustomerAndAssetsModule = document.querySelectorAll(".classCustomerAndAssetsModule");

	var eventWorkOrderManagementModule = document.querySelectorAll(".classWorkOrderManagementModule");

	var eventWorkOrderReportsModule = document.querySelectorAll(".classWorkOrderReportsModule");

	var eventAmcModule = document.querySelectorAll(".classAmcModule");

	var eventMaterialRequisitionModule  = document.querySelectorAll(".classMaterialRequisitionModule ");

	var eventCustomerFeedbackModule = document.querySelectorAll(".classCustomerFeedbackModule");

	var eventHRModule = document.querySelectorAll(".classHRModule");


	var eventEmployeeListPDF = document.querySelectorAll(".classEmployeeListPDF");


	var eventCPRExpiryPDF = document.querySelectorAll(".classCPRExpiryPDF");

	var eventVisaExpiryPDF = document.querySelectorAll(".classVisaExpiryPDF");

	var eventCustomersExportExcel = document.querySelectorAll(".classCustomersExportExcel");

	var eventCustomerDirectoryPDF = document.querySelectorAll(".classCustomerDirectoryPDF");

	var eventDownloadAssetsPrintQR = document.querySelectorAll(".classDownloadAssetsPrintQR");

	var eventDownloadAndAssetsExcel = document.querySelectorAll(".classDownloadAndAssetsExcel");

	var eventDownloadAndAssetsPDF = document.querySelectorAll(".classDownloadAndAssetsPDF");

	var eventWorkOrdersClosedExcel = document.querySelectorAll(".classWorkOrdersClosedExcel");

	var eventWorkOrdersClosedPDF = document.querySelectorAll(".classWorkOrdersClosedPDF");

	var eventWorkOrdersCancelledPDF = document.querySelectorAll(".classWorkOrdersCancelledPDF");

	var eventWorkOrdersCancelledExcel = document.querySelectorAll(".classWorkOrdersCancelledExcel");

	var eventWOReportsScheduledPDF = document.querySelectorAll(".classWOReportsScheduledPDF");

	var eventWOReportsScheduledExcel = document.querySelectorAll(".classWOReportsScheduledExcel");

	var eventWOReportsAssignedPDF = document.querySelectorAll(".classWOReportsAssignedPDF");

	var eventWOReportsAssignedExport = document.querySelectorAll(".classWOReportsAssignedExport");

	var eventWOReportsExtendedPDF = document.querySelectorAll(".classWOReportsExtendedPDF");

	var eventWOReportsExtendedExcel = document.querySelectorAll(".classWOReportsExtendedExcel");

	var eventWOReportsCompletedPDF = document.querySelectorAll(".classWOReportsCompletedPDF");

	var eventWOReportsCompletedExcel = document.querySelectorAll(".classWOReportsCompletedExcel");

	var eventWOReportsClosedPDF = document.querySelectorAll(".classWOReportsClosedPDF");

	var eventWOReportsClosedExcel = document.querySelectorAll(".classWOReportsClosedExcel");

	var eventWOReportsCancelledPDF = document.querySelectorAll(".classWOReportsCancelledPDF");


	var eventWOReportsCancelledExcel = document.querySelectorAll(".classWOReportsCancelledExcel");


	var eventWOReportsDailyTeamReportPDF = document.querySelectorAll(".classWOReportsDailyTeamReportPDF");

	var eventWOReportsDailyActivityLogPDF = document.querySelectorAll(".classWOReportsDailyActivityLogPDF");

	var eventListOfAMCExcel = document.querySelectorAll(".classListOfAMCExcel");




	var eventSearchAMCReport = document.querySelectorAll(".classSearchAMCReport");

	var eventAMCRenewalExportExcel = document.querySelectorAll(".classAMCRenewalExportExcel");

	var eventAMCRenewalReport = document.querySelectorAll(".classAMCRenewalReport");

	var eventPrintWO = document.querySelectorAll(".classPrintWO");

	var eventPrintSR = document.querySelectorAll(".classPrintSR");

	var eventClosedWOPrint = document.querySelectorAll(".classClosedWOPrint");

	var eventClosedSRPrint = document.querySelectorAll(".classClosedSRPrint");

	var eventWoCancelledModify = document.querySelectorAll(".classWoCancelledModify");

	var eventCancelledWOPrint = document.querySelectorAll(".classCancelledWOPrint");

	var eventCancelledSRPrint = document.querySelectorAll(".classCancelledSRPrint");



	var eventQuotation = document.querySelectorAll(".classQuotation");

	var eventCreateQuotation = document.querySelectorAll(".classCreateQuotation");




	var eventViewQuotation = document.querySelectorAll(".classViewQuotation");

	var eventViewQuotationRevision = document.querySelectorAll(".classViewQuotationRevision");





	var eventLocalPOModule = document.querySelectorAll(".classLocalPOModule");

	var eventCreateLocalPO = document.querySelectorAll(".classCreateLocalPO");


	var eventViewLocalPO = document.querySelectorAll(".classViewLocalPO");
	// add_new_var
	
	
		// Donot Remove The above line 



//     addActionButtons.forEach(function(obj) {
//          if (!hasPermission("ExportToExcel")) {
//             obj.style.display = "none";
//         }
//     });

//     editActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });

//     deleteActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });

//     listActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });
	
// 	saveActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });
    
// 	uploadActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });
	
// 	printActionButtons.forEach(function(obj) {
//             obj.style.display = "none";
//         }
//     });
	
	exportToExcelActionButtons.forEach(function(obj) {
        if (!hasPermission("ExportToExcel")) {
            obj.style.display = "none";
        }
    });
	
	exportToPDFActionButtons.forEach(function(obj) {
	    if (!hasPermission("ExportToPDF")) {
            obj.style.display = "none";
        }
    });
	















	eventCalenderView.forEach(function(obj) {if (!hasPermission("CalenderView")) {obj.style.display = "none";}});

	eventCalenderModify.forEach(function(obj) {if (!hasPermission("CalenderModify")) {obj.style.display = "none";}});

	eventExpertiseView.forEach(function(obj) {if (!hasPermission("ExpertiseView")) {obj.style.display = "none";}});

	eventExpertiseModify.forEach(function(obj) {if (!hasPermission("ExpertiseModify")) {obj.style.display = "none";}});

	eventEmployeesView.forEach(function(obj) {if (!hasPermission("EmployeesView")) {obj.style.display = "none";}});

	eventEmployeesModify.forEach(function(obj) {if (!hasPermission("EmployeesModify")) {obj.style.display = "none";}});

	eventCPRAndVisaExpiryView.forEach(function(obj) {if (!hasPermission("CPRAndVisaExpiryView")) {obj.style.display = "none";}});

	eventLocationAndFacilitiesView.forEach(function(obj) {if (!hasPermission("LocationAndFacilitiesView")) {obj.style.display = "none";}});

	eventLocationAndFacilitiesModify.forEach(function(obj) {if (!hasPermission("LocationAndFacilitiesModify")) {obj.style.display = "none";}});

	eventContractTypeAndAssetCategoryView.forEach(function(obj) {if (!hasPermission("ContractTypeAndAssetCategoryView")) {obj.style.display = "none";}});

	eventContractTypeAndAssetCategoryModify.forEach(function(obj) {if (!hasPermission("ContractTypeAndAssetCategoryModify")) {obj.style.display = "none";}});

	eventAssetTypeView.forEach(function(obj) {if (!hasPermission("AssetTypeView")) {obj.style.display = "none";}});

	eventAssetTypeModify.forEach(function(obj) {if (!hasPermission("AssetTypeModify")) {obj.style.display = "none";}});

	eventServicesView.forEach(function(obj) {if (!hasPermission("ServicesView")) {obj.style.display = "none";}});

	eventServicesModify.forEach(function(obj) {if (!hasPermission("ServicesModify")) {obj.style.display = "none";}});

	eventCustomerView.forEach(function(obj) {if (!hasPermission("CustomerView")) {obj.style.display = "none";}});

	eventCustomerModify.forEach(function(obj) {if (!hasPermission("CustomerModify")) {obj.style.display = "none";}});

	eventCustomerFacilityView.forEach(function(obj) {if (!hasPermission("CustomerFacilityView")) {obj.style.display = "none";}});

	eventCustomerFacilityModify.forEach(function(obj) {if (!hasPermission("CustomerFacilityModify")) {obj.style.display = "none";}});

	eventCustomerAssetView.forEach(function(obj) {if (!hasPermission("CustomerAssetView")) {obj.style.display = "none";}});

	eventCustomerAssetModify.forEach(function(obj) {if (!hasPermission("CustomerAssetModify")) {obj.style.display = "none";}});

	eventCustomerDirectoryView.forEach(function(obj) {if (!hasPermission("CustomerDirectoryView")) {obj.style.display = "none";}});

	eventCustomerDirectoryModify.forEach(function(obj) {if (!hasPermission("CustomerDirectoryModify")) {obj.style.display = "none";}});

	eventBookWoView.forEach(function(obj) {if (!hasPermission("BookWoView")) {obj.style.display = "none";}});

	eventBookWoModify.forEach(function(obj) {if (!hasPermission("BookWoModify")) {obj.style.display = "none";}});

	eventWoOpenedView.forEach(function(obj) {if (!hasPermission("WoOpenedView")) {obj.style.display = "none";}});

	eventWoOpenedModify.forEach(function(obj) {if (!hasPermission("WoOpenedModify")) {obj.style.display = "none";}});

	eventWoScheduledView.forEach(function(obj) {if (!hasPermission("WoScheduledView")) {obj.style.display = "none";}});

	eventWoScheduledModify.forEach(function(obj) {if (!hasPermission("WoScheduledModify")) {obj.style.display = "none";}});

	eventWoAssignedView.forEach(function(obj) {if (!hasPermission("WoAssignedView")) {obj.style.display = "none";}});

	eventWoAssignedModify.forEach(function(obj) {if (!hasPermission("WoAssignedModify")) {obj.style.display = "none";}});

	eventWoExtensionView.forEach(function(obj) {if (!hasPermission("WoExtensionView")) {obj.style.display = "none";}});

	eventWoExtensionModify.forEach(function(obj) {if (!hasPermission("WoExtensionModify")) {obj.style.display = "none";}});

	eventWoCompletedView.forEach(function(obj) {if (!hasPermission("WoCompletedView")) {obj.style.display = "none";}});

	eventWoCompletedModify.forEach(function(obj) {if (!hasPermission("WoCompletedModify")) {obj.style.display = "none";}});

	eventWoClosedView.forEach(function(obj) {if (!hasPermission("WoClosedView")) {obj.style.display = "none";}});

	eventWoClosedModify.forEach(function(obj) {if (!hasPermission("WoClosedModify")) {obj.style.display = "none";}});

	eventWoCancelledView.forEach(function(obj) {if (!hasPermission("WoCancelledView")) {obj.style.display = "none";}});

	eventWoEscalatedView.forEach(function(obj) {if (!hasPermission("WoEscalatedView")) {obj.style.display = "none";}});

	eventWoEscalatedModify.forEach(function(obj) {if (!hasPermission("WoEscalatedModify")) {obj.style.display = "none";}});

	eventWoReport.forEach(function(obj) {if (!hasPermission("WoReport")) {obj.style.display = "none";}});

	eventTrackWo.forEach(function(obj) {if (!hasPermission("TrackWo")) {obj.style.display = "none";}});

	eventDailyTeamReport.forEach(function(obj) {if (!hasPermission("DailyTeamReport")) {obj.style.display = "none";}});

	eventDailyActivityReport.forEach(function(obj) {if (!hasPermission("DailyActivityReport")) {obj.style.display = "none";}});

	eventWoExport.forEach(function(obj) {if (!hasPermission("WoExport")) {obj.style.display = "none";}});

	eventServiceReportExport.forEach(function(obj) {if (!hasPermission("ServiceReportExport")) {obj.style.display = "none";}});

	eventSubContractorsView.forEach(function(obj) {if (!hasPermission("SubContractorsView")) {obj.style.display = "none";}});

	eventSubContractorsModify.forEach(function(obj) {if (!hasPermission("SubContractorsModify")) {obj.style.display = "none";}});

	eventBookAMC.forEach(function(obj) {if (!hasPermission("BookAMC")) {obj.style.display = "none";}});

	eventSearchAMC.forEach(function(obj) {if (!hasPermission("SearchAMC")) {obj.style.display = "none";}});

	eventScheduleAMC.forEach(function(obj) {if (!hasPermission("ScheduleAMC")) {obj.style.display = "none";}});

	eventAssignServicesAMC.forEach(function(obj) {if (!hasPermission("AssignServicesAMC")) {obj.style.display = "none";}});

	eventAssignTechniciansAMC.forEach(function(obj) {if (!hasPermission("AssignTechniciansAMC")) {obj.style.display = "none";}});

	eventAMCReschedule.forEach(function(obj) {if (!hasPermission("AMCReschedule")) {obj.style.display = "none";}});

	eventCompletedAMCView.forEach(function(obj) {if (!hasPermission("CompletedAMCView")) {obj.style.display = "none";}});

	eventCompletedAMCModify.forEach(function(obj) {if (!hasPermission("CompletedAMCModify")) {obj.style.display = "none";}});

	eventClosedAMCView.forEach(function(obj) {if (!hasPermission("ClosedAMCView")) {obj.style.display = "none";}});

	eventClosedAMCModify.forEach(function(obj) {if (!hasPermission("ClosedAMCModify")) {obj.style.display = "none";}});

	eventRenewAMC.forEach(function(obj) {if (!hasPermission("RenewAMC")) {obj.style.display = "none";}});

	eventMaterialRequisitionView.forEach(function(obj) {if (!hasPermission("MaterialRequisitionView")) {obj.style.display = "none";}});

	eventMaterialRequisitionModify.forEach(function(obj) {if (!hasPermission("MaterialRequisitionModify")) {obj.style.display = "none";}});

	eventLogsView.forEach(function(obj) {if (!hasPermission("LogsView")) {obj.style.display = "none";}});

	eventDashboard.forEach(function(obj) {if (!hasPermission("Dashboard")) {obj.style.display = "none";}});


	eventCustomerFeedbackReportView.forEach(function(obj) {if (!hasPermission("CustomerFeedbackReportView")) {obj.style.display = "none";}});



	eventGivePermission.forEach(function(obj) {if (!hasPermission("GivePermission")) {obj.style.display = "none";}});






	eventExportToPDF.forEach(function(obj) {if (!hasPermission("ExportToPDF")) {obj.style.display = "none";}});







	eventAssetsAndServiceModule.forEach(function(obj) {if (!hasPermission("AssetsAndServiceModule")) {obj.style.display = "none";}});

	eventCustomerAndAssetsModule.forEach(function(obj) {if (!hasPermission("CustomerAndAssetsModule")) {obj.style.display = "none";}});

	eventWorkOrderManagementModule.forEach(function(obj) {if (!hasPermission("WorkOrderManagementModule")) {obj.style.display = "none";}});

	eventWorkOrderReportsModule.forEach(function(obj) {if (!hasPermission("WorkOrderReportsModule")) {obj.style.display = "none";}});

	eventAmcModule.forEach(function(obj) {if (!hasPermission("AmcModule")) {obj.style.display = "none";}});

	eventMaterialRequisitionModule .forEach(function(obj) {if (!hasPermission("MaterialRequisitionModule")) {obj.style.display = "none";}});

	eventCustomerFeedbackModule.forEach(function(obj) {if (!hasPermission("CustomerFeedbackModule")) {obj.style.display = "none";}});

	eventHRModule.forEach(function(obj) {if (!hasPermission("HRModule")) {obj.style.display = "none";}});


	eventEmployeeListPDF.forEach(function(obj) {if (!hasPermission("EmployeeListPDF")) {obj.style.display = "none";}});


	eventCPRExpiryPDF.forEach(function(obj) {if (!hasPermission("CPRExpiryPDF")) {obj.style.display = "none";}});

	eventVisaExpiryPDF.forEach(function(obj) {if (!hasPermission("VisaExpiryPDF")) {obj.style.display = "none";}});

	eventCustomersExportExcel.forEach(function(obj) {if (!hasPermission("CustomersExportExcel")) {obj.style.display = "none";}});

	eventCustomerDirectoryPDF.forEach(function(obj) {if (!hasPermission("CustomerDirectoryPDF")) {obj.style.display = "none";}});

	eventDownloadAssetsPrintQR.forEach(function(obj) {if (!hasPermission("DownloadAssetsPrintQR")) {obj.style.display = "none";}});

	eventDownloadAndAssetsExcel.forEach(function(obj) {if (!hasPermission("DownloadAndAssetsExcel")) {obj.style.display = "none";}});

	eventDownloadAndAssetsPDF.forEach(function(obj) {if (!hasPermission("DownloadAndAssetsPDF")) {obj.style.display = "none";}});

	eventWorkOrdersClosedExcel.forEach(function(obj) {if (!hasPermission("WorkOrdersClosedExcel")) {obj.style.display = "none";}});

	eventWorkOrdersClosedPDF.forEach(function(obj) {if (!hasPermission("WorkOrdersClosedPDF")) {obj.style.display = "none";}});

	eventWorkOrdersCancelledPDF.forEach(function(obj) {if (!hasPermission("WorkOrdersCancelledPDF")) {obj.style.display = "none";}});

	eventWorkOrdersCancelledExcel.forEach(function(obj) {if (!hasPermission("WorkOrdersCancelledExcel")) {obj.style.display = "none";}});

	eventWOReportsScheduledPDF.forEach(function(obj) {if (!hasPermission("WOReportsScheduledPDF")) {obj.style.display = "none";}});

	eventWOReportsScheduledExcel.forEach(function(obj) {if (!hasPermission("WOReportsScheduledExcel")) {obj.style.display = "none";}});

	eventWOReportsAssignedPDF.forEach(function(obj) {if (!hasPermission("WOReportsAssignedPDF")) {obj.style.display = "none";}});

	eventWOReportsAssignedExport.forEach(function(obj) {if (!hasPermission("WOReportsAssignedExport")) {obj.style.display = "none";}});

	eventWOReportsExtendedPDF.forEach(function(obj) {if (!hasPermission("WOReportsExtendedPDF")) {obj.style.display = "none";}});

	eventWOReportsExtendedExcel.forEach(function(obj) {if (!hasPermission("WOReportsExtendedExcel")) {obj.style.display = "none";}});

	eventWOReportsCompletedPDF.forEach(function(obj) {if (!hasPermission("WOReportsCompletedPDF")) {obj.style.display = "none";}});

	eventWOReportsCompletedExcel.forEach(function(obj) {if (!hasPermission("WOReportsCompletedExcel")) {obj.style.display = "none";}});

	eventWOReportsClosedPDF.forEach(function(obj) {if (!hasPermission("WOReportsClosedPDF")) {obj.style.display = "none";}});

	eventWOReportsClosedExcel.forEach(function(obj) {if (!hasPermission("WOReportsClosedExcel")) {obj.style.display = "none";}});

	eventWOReportsCancelledPDF.forEach(function(obj) {if (!hasPermission("WOReportsCancelledPDF")) {obj.style.display = "none";}});


	eventWOReportsCancelledExcel.forEach(function(obj) {if (!hasPermission("WOReportsCancelledExcel")) {obj.style.display = "none";}});


	eventWOReportsDailyTeamReportPDF.forEach(function(obj) {if (!hasPermission("WOReportsDailyTeamReportPDF")) {obj.style.display = "none";}});

	eventWOReportsDailyActivityLogPDF.forEach(function(obj) {if (!hasPermission("WOReportsDailyActivityLogPDF")) {obj.style.display = "none";}});

	eventListOfAMCExcel.forEach(function(obj) {if (!hasPermission("ListOfAMCExcel")) {obj.style.display = "none";}});




	eventSearchAMCReport.forEach(function(obj) {if (!hasPermission("SearchAMCReport")) {obj.style.display = "none";}});

	eventAMCRenewalExportExcel.forEach(function(obj) {if (!hasPermission("AMCRenewalExportExcel")) {obj.style.display = "none";}});

	eventAMCRenewalReport.forEach(function(obj) {if (!hasPermission("AMCRenewalReport")) {obj.style.display = "none";}});

	eventPrintWO.forEach(function(obj) {if (!hasPermission("PrintWO")) {obj.style.display = "none";}});

	eventPrintSR.forEach(function(obj) {if (!hasPermission("PrintSR")) {obj.style.display = "none";}});

	eventClosedWOPrint.forEach(function(obj) {if (!hasPermission("ClosedWOPrint")) {obj.style.display = "none";}});

	eventClosedSRPrint.forEach(function(obj) {if (!hasPermission("ClosedSRPrint")) {obj.style.display = "none";}});

	eventWoCancelledModify.forEach(function(obj) {if (!hasPermission("WoCancelledModify")) {obj.style.display = "none";}});

	eventCancelledWOPrint.forEach(function(obj) {if (!hasPermission("CancelledWOPrint")) {obj.style.display = "none";}});

	eventCancelledSRPrint.forEach(function(obj) {if (!hasPermission("CancelledSRPrint")) {obj.style.display = "none";}});



	eventQuotation.forEach(function(obj) {if (!hasPermission("QuotationModule")) {obj.style.display = "none";}});

	eventCreateQuotation.forEach(function(obj) {if (!hasPermission("CreateQuotation")) {obj.style.display = "none";}});




	eventViewQuotation.forEach(function(obj) {if (!hasPermission("ViewQuotation")) {obj.style.display = "none";}});

	eventViewQuotationRevision.forEach(function(obj) {if (!hasPermission("ViewQuotationRevision")) {obj.style.display = "none";}});





	eventLocalPOModule.forEach(function(obj) {if (!hasPermission("LocalPOModule")) {obj.style.display = "none";}});

	eventCreateLocalPO.forEach(function(obj) {if (!hasPermission("CreateLocalPO")) {obj.style.display = "none";}});


	eventViewLocalPO.forEach(function(obj) {if (!hasPermission("ViewLocalPO")) {obj.style.display = "none";}});
	// adding_new_permission
	
		// Donot Remove The above line 
});

