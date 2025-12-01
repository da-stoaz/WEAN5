using System.ComponentModel.DataAnnotations;

namespace DeviceApiForMobile.DeviceInfo;

public sealed record CreateDeviceInfoModel(
    [property: MaxLength(50)] string DeviceName,
    [property: MaxLength(50)] string Manufacturer,
    [property: MaxLength(50)] string? SerialNumber,
    [property: MaxLength(250)] string? Description
);