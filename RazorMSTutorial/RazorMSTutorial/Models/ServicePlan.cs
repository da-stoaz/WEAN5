using System.ComponentModel.DataAnnotations;
using Microsoft.EntityFrameworkCore;

namespace RazorMSTutorial.Models;

public class ServicePlan
{
    public int Id { get; set; }
    public required string Type { get; set; }
    public DateTime TimeStamp { get; set; }
    [Precision(10,2)]
    public decimal Duration { get; set; }
    [MaxLength(1024)]
    public string? Description { get; set; }
    
    public int? PublicTransportId { get; set; }

}