/* Demo Note: This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks. These aren't part of the SWFUpload
   package. They are part of my application. Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */


/* ===================
v2.1.0 Beta 2 - Tested
03.30.08 - Created minsec function to clean up a few variables

Modifications made by Daem0nX (03.29.08)
Please note I dont work with JS very often so...
There is no warranty with this code.
Hope this helps some of those asking / wanting / needing this code update.
To the devs of SWFUpload - Keep up the awesome work =)

Modification to uploadStart
Captures start time (iTime)

Modification to uploadSuccess
Now shows "Completed in xx.yy minutes/seconds

Additional vars that can be used in UploadProgress
Default info format - 0.1 of 3 MB at 51 KB/sec; 01:39 remain (2%)
Look in that section for more info
Upload speed
Time elapsed
Time remaining

=================== */
var iTime = ""; //intial time
var Timeleft = ""; //time left

//roundNumber found via google
function roundNumber(num, dec) {
var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
return result;
}

//minsec created by Daem0nX (03.29.08)
function minsec(time, tempTime) {
var ztime;
if (time == "m") {
   ztime = Math.floor(tempTime/60);
   if (ztime < 10) {
    ztime = "0" + ztime;
   }
} else if (time == "s") {
   ztime = Math.ceil(tempTime % 60);
   if (ztime < 10) {
    ztime = "0" + ztime;
   }
} else {
   ztime = "minsec error...";
}
return ztime;
}
  

function fileQueued(file) {
try {
   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setStatus("等待...");
   progress.toggleCancel(true, this);

} catch (ex) {
   this.debug(ex);
}

}

function fileQueueError(file, errorCode, message) {
try {
   if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
    alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
    return;
   }

   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setError();
   progress.toggleCancel(false);

   switch (errorCode) {
   case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
    progress.setStatus("文件超过大小限制.");
    this.debug("错误代码: 文件超过大小限制, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
    progress.setStatus("文件大小位0.");
    this.debug("错误代码: 文件大小位0, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
    progress.setStatus("非法文件类型.");
    this.debug("错误代码: 非法文件类型, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   default:
    if (file !== null) {
     progress.setStatus("未知 错误");
    }
    this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   }
} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
try {
   if (numFilesSelected > 0) {
    document.getElementById(this.customSettings.cancelButtonId).disabled = false;
   }
  
   /* I want auto start the upload and I can do that here */
   this.startUpload();
} catch (ex) {
        this.debug(ex);
}
}

function uploadStart(file) {
try {
   /* I don't want to do any file validation or anything, I'll just update the UI and
   return true to indicate that the upload should start.
   It's important to update the UI here because in Linux no uploadProgress events are called. The best
   we can do is say we are uploading.
   */
   //Capture start time
   var currentTime = new Date()
   iTime = currentTime;
   //Set Timeleft to estimating
   Timeleft = "计算中...";
    
   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setStatus("Uploading...");
   progress.toggleCancel(true, this);
}
catch (ex) {}

return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
try {
   var currentTime = new Date()
   var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setProgress(percent);

   var tempTime = 0;
   //rndfilesize = round file size  
   var rndfilesize = roundNumber(((file.size/1024)/1024),1);
   //uploaded = how much has been uploaded
   var uploaded = roundNumber(((bytesLoaded/1024)/1024),1);
   //uTime = uploadTime (time spent uploading)
   var uTime = (Math.ceil(currentTime-iTime)/1000);
   //uSpeed = uploadSpeed (40 kB/s)
   var uSpeed = Math.floor(roundNumber(((bytesLoaded/uTime)/1024),2));
   //tempTime = store time for following functions
   var tempTime = uTime;
   //uploadTime in min:sec
   uTime = "用时" + minsec("m", tempTime) + "分:" + minsec("s", tempTime) + "秒";
   //tempTime = reassign val
   tempTime = roundNumber(((((bytesTotal-bytesLoaded)/uSpeed)/60)/10),2);
   if (tempTime != "Infinity") {
    if (tempTime > 0) {
     //if greater than 0
     //Timeleft in min:sec
     Timeleft = minsec("m", tempTime) + "分:" + minsec("s", tempTime) + '秒';
    } else {
     Timeleft = "计算中...";
    }
   } else {
    Timeleft = "计算中...";
   }
  
   //Variables available
   //uSpeed = the rate of upload (40 kB/s)
   //uploaded = how much of the file has upload in MB
   //rndfilesize = file size in MB
   //uTime = how much time has been spent uploading in min:sec (xx:yy elapsed)
   //Timeleft = how much time is left in min:sec (xx:yy remain)
   progress.setStatus('<b><span style="font-size:10px;"><font color=red>' +uploaded + '</font></b>/' + rndfilesize + ' MB,上传速度: <b><font color=red>' + uSpeed + ' </font></b>KB/秒; 剩余时间: <b><font color=red>' + Timeleft + '</font></b>; 总进度 <b><font color=red>' + percent + '%</font></span></b>');
    
} catch (ex) {
   this.debug(ex);
}
}

function uploadSuccess(file, serverData) {
try {
   var currentTime = new Date()
   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setComplete();
   //Calculate upload time
   var cTime = (Math.ceil(currentTime-iTime)/1000);
   var zmin = 0;
   var zsec = 0;
   zmin = Math.floor(cTime/60);
   if (zmin < 10) {
    zmin = "0" + zmin;
   }
   zsec = Math.ceil(cTime % 60);
   if (zsec < 10) {
    zsec = "0" + zsec;
   }
   //Show how long the upload took
   progress.setStatus("上传完成，用时:<b><font color=red> " + zmin + "分:" + zsec + '秒</font></b>');
   progress.toggleCancel(false);
   document.getElementById(this.customSettings.img).value += '|' +serverData;
} catch (ex) {
   this.debug(ex);
}
}

function uploadError(file, errorCode, message) {
try {
   var progress = new FileProgress(file, this.customSettings.progressTarget);
   progress.setError();
   progress.toggleCancel(false);

   switch (errorCode) {
   case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
    progress.setStatus("Upload Error: " + message);
    this.debug("错误代码: HTTP 错误, 文件名: " + file.name + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
    progress.setStatus("上传 失败.");
    this.debug("错误代码: 上传失败, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.IO_ERROR:
    progress.setStatus("服务器 (IO) 错误");
    this.debug("错误代码: IO 错误, 文件名: " + file.name + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
    progress.setStatus("安全 错误");
    this.debug("错误代码: 安全 错误, 文件名: " + file.name + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
    progress.setStatus("文件数量超过限制.");
    this.debug("错误代码: 文件数量超过限制, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
    progress.setStatus("检验文件失败，跳过上传.");
    this.debug("错误代码: 检验文件失败，跳过上传, 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
    // If there aren't any files left (they were all cancelled) disable the cancel button
    if (this.getStats().files_queued === 0) {
     document.getElementById(this.customSettings.cancelButtonId).disabled = true;
    }
    progress.setStatus("取消");
    progress.setCancelled();
    break;
   case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
    progress.setStatus("Stopped");
    break;
   default:
    progress.setStatus("未知错误: " + errorCode);
    this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 文件大小: " + file.size + ", 错误消息: " + message);
    break;
   }
} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
if (this.getStats().files_queued === 0) {
   document.getElementById(this.customSettings.cancelButtonId).disabled = true;
}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
var status = document.getElementById("divStatus");
status.innerHTML = numFilesUploaded + " 文件" + (numFilesUploaded === 1 ? "" : "s") + " 上传成功.";
}