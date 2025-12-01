using System.ComponentModel.DataAnnotations;

namespace DeviceApiForMobile.DeviceInfo;

public class DeviceInfo
{
    [Key]
    public Guid Id { get; set; } = Guid.NewGuid();
    
    [MaxLength(50)]
    public string DeviceName { get; set; } = string.Empty;
    
    [MaxLength(50)]
    public string Manufacturer { get; set; } = string.Empty;
    
    [MaxLength(50)]
    public string? SerialNumber { get; set; } = string.Empty;
    
    [MaxLength(250)]
    public string? Description { get; set; } = string.Empty;
    
    public DateTime UpdatedAt { get; set; } = DateTime.Now;
}